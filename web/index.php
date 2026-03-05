<?php
include 'config.php';

/* CONTACT FORM */
if(isset($_POST['send_message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contacts (name,email,phone,subject,message) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name,$email,$phone,$subject,$message);
    $stmt->execute();
    $stmt->close(); 

    echo "<script>alert('Message Sent Successfully!');</script>";
}

/* NEWSLETTER */
if(isset($_POST['subscribe'])) {
    $email = $_POST['newsletter_email'];

    $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Subscribed Successfully!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fred Chicken Business</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #FF8C00;
            --primary-dark: #E67E22;
            --secondary: #8B4513;
            --light: #FFF9E6;
            --dark: #333333;
            --success: #27AE60;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --shadow: 0 5px 20px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.7;
            color: var(--dark);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            line-height: 1.3;
        }

        .container {
            width: 90%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.8rem;
            color: var(--secondary);
            display: inline-block;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 3px;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(to right, var(--secondary), #A0522D);
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.4);
        }

        /* Enhanced Header */
        .header-top {
            background-color: var(--secondary);
            color: white;
            padding: 12px 0;
            font-size: 0.9rem;
        }

        .header-top-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-contact {
            display: flex;
            gap: 20px;
        }

        .header-contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .social-header {
            display: flex;
            gap: 15px;
        }

        .social-header a {
            color: white;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .social-header a:hover {
            color: var(--primary);
        }

        /* Main Navigation */
        .main-header {
            background-color: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .main-header.scrolled {
            padding: 5px 0;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            transition: var(--transition);
        }

        .main-header.scrolled .header-container {
            padding: 10px 0;
        }

        /* Custom Logo Design */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 15px;
            background: linear-gradient(135deg, #444444, #222222);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            box-shadow: var(--shadow);
            overflow: hidden;
            padding: 10px;
            text-align: center;
        }

        .logo-top {
            font-size: 1.2rem;
            font-weight: 900;
            color: #FF8C00;
            margin-bottom: 2px;
            letter-spacing: 1px;
        }

        .logo-main {
            font-size: 1.8rem;
            font-weight: 900;
            color: white;
            line-height: 1;
            margin-bottom: 2px;
        }

        .logo-bottom {
            font-size: 1rem;
            font-weight: 700;
            color: #FF8C00;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            font-size: 1.8rem;
            color: var(--secondary);
            line-height: 1.2;
        }

        .logo-text span {
            color: var(--primary);
            font-size: 1rem;
            font-weight: 500;
        }

        /* Enhanced Navigation */
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            position: relative;
            padding: 5px 0;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
            transition: var(--transition);
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a:hover::after,
        nav a.active::after {
            width: 100%;
        }

        nav a.active {
            color: var(--primary);
        }

        .nav-cta {
            margin-left: 10px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--secondary);
            cursor: pointer;
        }

        /* Advanced Hero Slider */
        .hero-slider {
            position: relative;
            height: 85vh;
            overflow: hidden;
            margin-bottom: 50px;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            position: relative;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .swiper-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.4));
        }

        .slide-content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 800px;
            padding: 0 30px;
            text-align: center;
        }

        .slide-content h1 {
            font-size: 3.5rem;
            margin-bottom: 25px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            line-height: 1.2;
        }

        .slide-content p {
            font-size: 1.3rem;
            margin-bottom: 35px;
            opacity: 0.9;
        }

        .slide-btns {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background-color: white;
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            background-color: var(--primary);
            opacity: 1;
        }

        /* Stats Section */
        .stats-section {
            background-color: var(--light);
            padding: 80px 0;
            margin-bottom: 50px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .stat-card {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 1.8rem;
        }

        .stat-number {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .stat-text {
            font-size: 1.2rem;
            color: #666;
        }

        /* About Section */
        .about-section {
            background-color: white;
        }

        .about-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 60px;
            align-items: center;
        }

        .about-image {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 500px;
            background-image: url('about.jpeg');
            background-size: cover;
            background-position: center;
        }

        .about-content h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 25px;
        }

        .about-content p {
            margin-bottom: 20px;
            color: #555;
            font-size: 1.1rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .about-feature i {
            color: var(--primary);
            font-size: 1.3rem;
            margin-top: 5px;
        }

        /* Products Section */
        .products-section {
            background-color: var(--light-gray);
        }

        .products-tabs {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 50px;
        }

        .tab-btn {
            padding: 12px 30px;
            background-color: white;
            border: 2px solid var(--medium-gray);
            border-radius: 50px;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .tab-btn.active,
        .tab-btn:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 35px;
        }

        .product-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .product-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .product-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: var(--success);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            z-index: 1;
        }

        .product-img {
            height: 220px;
            width: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .product-content {
            padding: 25px;
        }

        .product-content h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--secondary);
        }

        .product-content p {
            color: #666;
            margin-bottom: 20px;
        }

        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .price {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1.2rem;
            margin-left: 10px;
        }

        /* Payment Methods */
        .payment-section {
            background-color: white;
            text-align: center;
        }

        .payment-icons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
            margin: 50px 0;
        }

        .payment-icon {
            background-color: white;
            width: 100px;
            height: 100px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            color: var(--dark);
            box-shadow: var(--shadow);
            transition: var(--transition);
            padding: 15px;
        }

        .payment-icon:hover {
            transform: translateY(-10px);
        }

        .payment-icon.bk {
            color: #D2232A;
        }

        .payment-icon.momo {
            color: #9C1F60;
        }

        .payment-icon.airtel {
            color: #EF4123;
        }

        .payment-text {
            font-size: 0.9rem;
            margin-top: 10px;
            font-weight: 600;
        }

        /* Contact Section */
        .contact-section {
            background-color: var(--light);
        }

        .contact-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 50px;
        }

        .contact-info {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .contact-info h3 {
            color: var(--secondary);
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .contact-icon {
            background-color: var(--light);
            color: var(--primary);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            font-size: 1.3rem;
        }

        .contact-form {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }

        /* Location Section */
        .location-section {
            background-color: white;
        }

        .location-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .map-container {
            height: 500px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .map-placeholder {
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .map-placeholder i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--secondary);
        }

        .location-info h3 {
            color: var(--secondary);
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        .location-details {
            margin-bottom: 30px;
        }

        .location-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .location-icon {
            background-color: var(--light);
            color: var(--primary);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            font-size: 1.3rem;
        }

        .clickable-location {
            cursor: pointer;
            transition: var(--transition);
        }

        .clickable-location:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding-top: 80px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 60px;
        }

        .footer-column h3 {
            color: var(--primary);
            margin-bottom: 25px;
            font-size: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 12px;
        }

        .footer-column a {
            color: #ddd;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-column a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .newsletter-form {
            display: flex;
            margin-top: 20px;
        }

        .newsletter-input {
            flex-grow: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .newsletter-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .footer-bottom {
            text-align: center;
            padding: 25px 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #aaa;
            font-size: 0.9rem;
        }

        /* Order Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            position: relative;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #999;
        }

        .close:hover {
            color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .slide-content h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 992px) {
            nav ul {
                gap: 20px;
            }
            
            .section-title h2 {
                font-size: 2.5rem;
            }
            
            .slide-content h1 {
                font-size: 2.5rem;
            }
            
            .location-container {
                grid-template-columns: 1fr;
            }
            
            .logo {
                width: 70px;
                height: 70px;
                font-size: 0.8rem;
            }
            
            .logo-main {
                font-size: 1.5rem;
            }
            
            .logo-top {
                font-size: 1rem;
            }
            
            .logo-bottom {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .header-top {
                display: none;
            }
            
            .menu-toggle {
                display: block;
            }

            nav {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 300px;
                height: calc(100vh - 80px);
                background-color: white;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                padding: 40px 30px;
                transition: var(--transition);
                z-index: 999;
                overflow-y: auto;
            }

            nav.active {
                left: 0;
            }

            nav ul {
                flex-direction: column;
                gap: 0;
            }

            nav li {
                margin-bottom: 15px;
                width: 100%;
            }
            
            nav a {
                display: block;
                padding: 12px 0;
                border-bottom: 1px solid var(--light-gray);
            }
            
            .nav-cta {
                margin: 20px 0 0 0;
                width: 100%;
            }

            .hero-slider {
                height: 70vh;
            }
            
            .slide-content h1 {
                font-size: 2.2rem;
            }
            
            .slide-content p {
                font-size: 1.1rem;
            }
            
            .section-padding {
                padding: 70px 0;
            }
            
            .section-title h2 {
                font-size: 2.2rem;
            }
            
            .header-container {
                padding: 10px 0;
            }
            
            .logo {
                width: 60px;
                height: 60px;
                padding: 8px;
            }
            
            .logo-main {
                font-size: 1.3rem;
            }
            
            .logo-top {
                font-size: 0.9rem;
            }
            
            .logo-bottom {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .hero-slider {
                height: 60vh;
            }
            
            .slide-content h1 {
                font-size: 1.8rem;
            }
            
            .slide-btns {
                flex-direction: column;
                align-items: center;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .logo-text h1 {
                font-size: 1.5rem;
            }
            
            .about-container {
                grid-template-columns: 1fr;
            }
            
            .about-features {
                grid-template-columns: 1fr;
            }
            
            .logo-container {
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <div class="header-top">
        <div class="container header-top-container">
            <div class="header-contact">
                <div class="header-contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>+250 788 123 456</span>
                </div>
                <div class="header-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>muhirejoseph46@gmail.com</span>
                </div>
            </div>
            <div class="social-header">
                <a href="https://facebook.com/nijosephpro" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://instagram.com/nijosephpro12" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://wa.me/250788123456" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Header with Custom Logo -->
    <header class="main-header">
        <div class="container header-container">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-top"><img src="log.png" alt="Logo" style="max-width:100%; max-height:100%;"></div>
                    <div class="logo-main">fred chicken</div>
                    <div class="logo-bottom">company ltd</div>
                </div>
                <div class="logo-text">
                    <h1>Fred Chicken Business</h1>
                    <span>Premium Poultry & Equipment</span>
                </div>
            </div>
            
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <nav id="mainNav">
                <ul>
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#location">Location</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Advanced Hero Slider -->
    <section class="hero-slider" id="home">
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url('pootry.jpeg')">
                    <div class="slide-content">
                        <h1>Premium Quality Poultry Products in Musanze</h1>
                        <p>Fresh, healthy chickens and eggs from our local farm in Busogo Sector. Raised naturally without antibiotics for superior taste and nutrition.</p>
                        <div class="slide-btns">
                            <a href="#products" class="btn">Shop Now</a>
                            <a href="#about" class="btn btn-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image: url('machine.jpeg')">
                    <div class="slide-content">
                        <h1>Modern Poultry Equipment & Machines</h1>
                        <p>Advanced chicken farming machines for small and medium scale farmers. Increase your production with our efficient equipment.</p>
                        <div class="slide-btns">
                            <a href="#products" class="btn">View Machines</a>
                            <a href="#contact" class="btn btn-secondary">Get Quote</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image: url('eggs.jpeg')">
                    <div class="slide-content">
                        <h1>Farm Fresh Eggs Delivered Daily</h1>
                        <p>Nutritious eggs collected fresh every morning. Available for homes, restaurants, and businesses throughout Musanze.</p>
                        <div class="slide-btns">
                            <a href="#products" class="btn">Order Eggs</a>
                            <a href="#contact" class="btn btn-secondary">Delivery Info</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">500+</div>
                    <div class="stat-text">Happy Customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-number">1,200+</div>
                    <div class="stat-text">Orders Delivered</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-egg"></i>
                    </div>
                    <div class="stat-number">10,000+</div>
                    <div class="stat-text">Eggs Sold Monthly</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <div class="stat-number">50+</div>
                    <div class="stat-text">Machines Installed</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section-padding" id="about">
        <div class="container">
            <div class="section-title">
                <h2>About Fred Chicken Business</h2>
                <p>Learn about our story, mission, and commitment to providing the best poultry products in Musanze</p>
            </div>
            
            <div class="about-container">
                <div class="about-image"></div>
                
                <div class="about-content">
                    <h2>Our Story & Mission</h2>
                    <p>Fred Chicken Business was founded in 2020 by Joseph Muhire with a vision to revolutionize poultry farming in Musanze District. What started as a small family farm in Byangabo Center, Busogo Sector has grown into one of the leading poultry businesses in the region.</p>
                    
                    <p>Our mission is to provide high-quality, affordable poultry products while promoting sustainable farming practices. We believe in supporting local farmers and contributing to food security in Rwanda.</p>
                    
                    <p>We specialize in three main areas: fresh chicken supply, daily egg production, and poultry farming equipment. Our chickens are raised in free-range conditions, fed with natural feeds, and carefully monitored for health and growth.</p>
                    
                    <p>With our modern chicken machines, we help other farmers increase their production efficiency. These machines are designed specifically for the Rwandan climate and farming conditions, making them perfect for small to medium-scale operations.</p>
                    
                    <div class="about-features">
                        <div class="about-feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Quality Guarantee</h4>
                                <p>All products meet highest standards</p>
                            </div>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-shipping-fast"></i>
                            <div>
                                <h4>Fast Delivery</h4>
                                <p>Free delivery within Musanze</p>
                            </div>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-handshake"></i>
                            <div>
                                <h4>Trusted Supplier</h4>
                                <p>Reliable service since 2020</p>
                            </div>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-headset"></i>
                            <div>
                                <h4>24/7 Support</h4>
                                <p>Always available to help</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#contact" class="btn" style="margin-top: 30px;">Contact Us Today</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section - Dynamic from Database -->
    <section class="products-section section-padding" id="products">
        <div class="container">
            <div class="section-title">
                <h2>Our Premium Products</h2>
                <p>High-quality poultry products and equipment for homes, restaurants, and farms</p>
            </div>
            
            <div class="products-tabs">
                <button class="tab-btn active" data-category="all">All Products</button>
                <button class="tab-btn" data-category="chicken">Fresh Chicken</button>
                <button class="tab-btn" data-category="eggs">Eggs</button>
                <button class="tab-btn" data-category="machines">Machines</button>
                <button class="tab-btn" data-category="accessories">Accessories</button>
            </div>
            
            <div class="products-grid">
                <?php
                // Fetch products from database
                $products_query = "SELECT * FROM products ORDER BY is_featured DESC, id DESC";
                $products_result = $conn->query($products_query);
                
                if ($products_result->num_rows > 0) {
                    while($product = $products_result->fetch_assoc()) {
                        ?>
                        <div class="product-card" data-category="<?php echo $product['category']; ?>">
                            <div class="product-img" style="background-image: url('<?php echo $product['image']; ?>')">
                                <?php if($product['badge']) { ?>
                                    <div class="product-badge"><?php echo $product['badge']; ?></div>
                                <?php } ?>
                            </div>
                            <div class="product-content">
                                <h3><?php echo $product['name']; ?></h3>
                                <p><?php echo $product['description']; ?></p>
                                <div class="product-price">
                                    <div class="price"><?php echo number_format($product['price']); ?> RWF 
                                        <?php if($product['old_price']) { ?>
                                            <span class="old-price"><?php echo number_format($product['old_price']); ?> RWF</span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <button class="btn order-btn" onclick="openOrderModal(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>', <?php echo $product['price']; ?>)">Order Now</button>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="location-section section-padding" id="location">
        <div class="container">
            <div class="section-title">
                <h2>Our Location</h2>
                <p>Visit us at our farm and store in Musanze. We're conveniently located in Byangabo Center, Busogo Sector.</p>
            </div>
            
            <div class="location-container">
                <div class="map-container">
                    <div class="map-placeholder">
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>Fred Chicken Business Location</h3>
                        <p>Byangabo Center, Busogo Sector</p>
                        <p>Musanze, Rwanda</p>
                        <a href="https://maps.google.com/?q=Byangabo+Center,+Busogo+Sector,+Musanze,+Rwanda" class="btn" target="_blank" style="margin-top: 20px;">Open in Google Maps</a>
                    </div>
                </div>
                
                <div class="location-info">
                    <h3>Visit Our Farm & Store</h3>
                    
                    <div class="location-details">
                        <div class="location-item">
                            <div class="location-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4>Address</h4>
                                <p class="clickable-location" onclick="openLocationInMaps()">Byangabo Center, Busogo Sector</p>
                                <p class="clickable-location" onclick="openLocationInMaps()">Musanze, Northern Province, Rwanda</p>
                                <p style="color: #777; font-size: 0.9rem; margin-top: 5px;">(Click address to open in maps)</p>
                            </div>
                        </div>
                        
                        <div class="location-item">
                            <div class="location-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4>Opening Hours</h4>
                                <p><strong>Monday - Saturday:</strong> 7:00 AM - 8:00 PM</p>
                                <p><strong>Sunday:</strong> 8:00 AM - 6:00 PM</p>
                                <p><strong>Holidays:</strong> 9:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                        
                        <div class="location-item">
                            <div class="location-icon">
                                <i class="fas fa-directions"></i>
                            </div>
                            <div>
                                <h4>How to Get Here</h4>
                                <p>From Musanze town center, take the road toward Kinigi. Turn left at Busogo trading center and continue for 2km until you reach Byangabo Center. Look for our large signboard with the Fred Chicken Business logo.</p>
                            </div>
                        </div>
                        
                        <div class="location-item">
                            <div class="location-icon">
                                <i class="fas fa-parking"></i>
                            </div>
                            <div>
                                <h4>Parking Available</h4>
                                <p>Ample parking space available for cars, motorcycles, and bicycles. Secure parking area with CCTV surveillance.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 30px;">
                        <button class="btn" onclick="openLocationInMaps()">Get Directions</button>
                        <a href="tel:+250788690115" class="btn btn-secondary" style="margin-left: 15px;">Call Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Section -->
    <section class="payment-section section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Easy & Secure Payments</h2>
                <p>We accept multiple payment methods for your convenience. Your transactions are safe with us.</p>
            </div>
            
            <div class="payment-icons">
                <div class="payment-icon bk">
                    <i class="fas fa-university"></i>
                    <div class="payment-text">Bank Transfer</div>
                </div>
                <div class="payment-icon momo">
                    <i class="fas fa-mobile-alt"></i>
                    <div class="payment-text">Mobile Money</div>
                </div>
                <div class="payment-icon airtel">
                    <i class="fas fa-signal"></i>
                    <div class="payment-text">Airtel Money</div>
                </div>
                <div class="payment-icon">
                    <i class="fas fa-credit-card"></i>
                    <div class="payment-text">Credit Card</div>
                </div>
                <div class="payment-icon">
                    <i class="fas fa-money-bill-wave"></i>
                    <div class="payment-text">Cash on Delivery</div>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="#contact" class="btn" style="padding: 18px 45px; font-size: 1.2rem;">Place Your Order Now</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Contact Us</h2>
                <p>Get in touch with us for orders, inquiries, or partnership opportunities</p>
            </div>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Get In Touch</h3>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4>Our Location</h4>
                            <p class="clickable-location" onclick="openLocationInMaps()">Byangabo Center, Busogo Sector, Musanze, Rwanda</p>
                            <p style="color: #777; font-size: 0.9rem; margin-top: 5px;">Open: Mon-Sun 7:00 AM - 8:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h4>Phone Number</h4>
                            <p>+250 788 123 456 (Call/WhatsApp)</p>
                            <p>+250 789 987 654 (Alternate)</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4>Email Address</h4>
                            <p>muhirejoseph46@gmail.com</p>
                            <p>orders@fredchickenbusiness.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div>
                            <h4>Follow Us</h4>
                            <div style="display: flex; gap: 15px; margin-top: 10px;">
                                <a href="https://facebook.com/nijosephpro" class="social-icon" style="display: inline-flex; width: 40px; height: 40px;" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://instagram.com/nijosephpro12" class="social-icon" style="display: inline-flex; width: 40px; height: 40px;" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://twitter.com" class="social-icon" style="display: inline-flex; width: 40px; height: 40px;" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/250788123456" class="social-icon" style="display: inline-flex; width: 40px; height: 40px;" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3 style="color: var(--secondary); margin-bottom: 25px;">Send us a Message</h3>
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Your Phone Number">
                        </div>
                        <div class="form-group">
                            <select name="subject" class="form-control" required>
                                <option value="" disabled selected>Select Subject</option>
                                <option value="order">Order Inquiry</option>
                                <option value="machine">Machine Inquiry</option>
                                <option value="partnership">Business Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" name="send_message" class="btn" style="width:100%;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Fred Chicken Business</h3>
                    <p style="margin-bottom: 20px; color: #ddd;">Your trusted partner for premium poultry products and farming equipment in Musanze and beyond.</p>
                    <div class="social-header">
                        <a href="https://facebook.com/nijosephpro" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://instagram.com/nijosephpro12" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/250788123456" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#location">Location</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Our Products</h3>
                    <ul>
                        <li><a href="#products">Fresh Chicken</a></li>
                        <li><a href="#products">Farm Eggs</a></li>
                        <li><a href="#products">Chicken Machines</a></li>
                        <li><a href="#products">Poultry Feed</a></li>
                        <li><a href="#products">Farming Equipment</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Newsletter</h3>
                    <p style="color: #ddd;">Subscribe to get updates on new products and special offers.</p>
                    <form method="POST" class="newsletter-form">
                        <input type="email" name="newsletter_email" class="newsletter-input" placeholder="Your Email" required>
                        <button type="submit" name="subscribe" class="newsletter-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 Fred Chicken Business. All Rights Reserved. | Byangabo Center, Busogo Sector, Musanze, Rwanda</p>
            </div>
        </div>
    </footer>

    <!-- Order Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeOrderModal()">&times;</span>
            <h2 style="color: var(--secondary); margin-bottom: 20px;">Place Your Order</h2>
            <form method="POST" action="process_order.php">
                <input type="hidden" name="product_id" id="modal_product_id">
                <input type="hidden" name="product_name" id="modal_product_name">
                <input type="hidden" name="price" id="modal_price">
                
                <div class="form-group">
                    <label>Your Full Name *</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="customer_email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="tel" name="customer_phone" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Product</label>
                    <input type="text" id="display_product" class="form-control" readonly>
                </div>
                
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required onchange="updateTotal()">
                </div>
                
                <div class="form-group">
                    <label>Unit Price</label>
                    <input type="text" id="display_price" class="form-control" readonly>
                </div>
                
                <div class="form-group">
                    <label>Total Price</label>
                    <input type="text" id="total_price" class="form-control" readonly>
                    <input type="hidden" name="total_price" id="total_price_hidden">
                </div>
                
                <div class="form-group">
                    <label>Payment Method *</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="">Select Payment Method</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Delivery Address *</label>
                    <textarea name="delivery_address" class="form-control" rows="3" required></textarea>
                </div>
                
                <button type="submit" name="place_order" class="btn" style="width:100%;">Confirm Order</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper slider
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            speed: 1000,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const mainNav = document.getElementById('mainNav');
        
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            menuToggle.innerHTML = mainNav.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });
        
        // Close menu when clicking on a link
        const navLinks = document.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mainNav.classList.remove('active');
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });
        
        // Sticky header on scroll
        const header = document.querySelector('.main-header');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Product tabs functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const productCards = document.querySelectorAll('.product-card');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                tabBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const category = this.getAttribute('data-category');
                
                // Show/hide products based on category
                productCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // Order Modal Functions
        function openOrderModal(productId, productName, price) {
            document.getElementById('modal_product_id').value = productId;
            document.getElementById('modal_product_name').value = productName;
            document.getElementById('modal_price').value = price;
            document.getElementById('display_product').value = productName;
            document.getElementById('display_price').value = price.toLocaleString() + ' RWF';
            document.getElementById('orderModal').style.display = 'block';
            updateTotal();
        }

        function closeOrderModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        function updateTotal() {
            const quantity = document.getElementById('quantity').value;
            const price = document.getElementById('modal_price').value;
            const total = quantity * price;
            document.getElementById('total_price').value = total.toLocaleString() + ' RWF';
            document.getElementById('total_price_hidden').value = total;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Initialize with header class if scrolled   
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        }
        
        // Function to open location in maps
        function openLocationInMaps() {
            const address = "Byangabo Center, Busogo Sector, Musanze, Rwanda";
            const mapsUrl = `https://maps.google.com/?q=${encodeURIComponent(address)}`;
            window.open(mapsUrl, '_blank');
        }
        
        // Make all location elements clickable
        const clickableLocations = document.querySelectorAll('.clickable-location');
        clickableLocations.forEach(location => {
            location.addEventListener('click', openLocationInMaps);
        });
    </script>
</body>
</html>