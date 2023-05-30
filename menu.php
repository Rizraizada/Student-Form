<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <style>
        .home4 .top-right .user a:after,
        .page .top-right .user a:after {
            left: 82px;
        }
        .dropdown-menu {
            display: block;
        }

        #header {
            z-index: auto;
        }

        .main-menu ul li .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            z-index: 999;
            background-color: #fff;
            padding: 50px;
        }

        .main-menu ul li:hover .dropdown-menu {
            display: block;
        }

        .main-menu ul li .dropdown-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-menu ul li .dropdown-menu ul li {
            margin: 0;
        }

        .main-menu ul li .dropdown-menu ul li a {
            display: block;
            padding: 10px;
            color: #000;
            text-decoration: none;
        }

        @media screen and (min-width: 1200px) {
            .home4 .main-menu,
            .home5 .main-menu {
                margin-left: 200px;
            }
            .header-content {
                max-height: 105px;
            }
            .home4 .main-menu > ul > li > a {
                line-height: 102px;
            }
            .home4 .site-brand a,
            .home5 .site-brand a {
                line-height: 102px;
            }
            .home4 .search-main .search-icon,
            .page .search-main .search-icon,
            .home5 .search-main .search-icon,
            .page-blog .search-main .search-icon {
                line-height: 102px;
            }
            .owl-stage-outer {
                width: 100%;
            }
            .search-main {
                max-height: 102px;
            }
        }

        @media screen and (max-width: 767px) {
            .home4 .header-content,
            .page .header-content,
            .home5 .header-content,
            .page-blog .header-content {
                padding: 0px 0;
            }
        }
    </style>
</head>
<body>

<header id="header" class="site-header">
    <div class="site-top">
        <div class="container">
            <div class="top-left">
                <p><i class="fa fa-question-circle-o" aria-hidden="true"></i><a href="mailto:anyoorinternational1000@gmail.com">anyoorinternational1000@gmail.com</a><span>or</span><a href="tel:+8801977134630">(+88) 01977 134630</a></p>
            </div>

            <div class="top-right">
                <ul>
                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                </ul>
                <div class="user">
                    <a href="#">Package</a>
                </div>
            </div>
        </div>
    </div><!-- .site-top -->

    <div class="header-content">
        <div class="container">
            <div class="site-brand">
                <a href="<?= base_url('/'); ?>">
                    <img src="<?= base_url('assets/images/logo/logo.jpg'); ?>" alt="" class="brand_logo" style="height: 26px;">
                </a>
            </div>

            <div class="menu-mobile">
                <button class="c-hamburger c-hamburger--htx"><span></span></button>
            </div><!-- .menu-mobile -->
            <div class="menu-bg"></div>

            <nav class="main-menu">
                <ul>
                    <li class="has-child <?php if ($this->uri->segment(1) == '') echo 'active' ?>">
                        <a href="<?= base_url('/'); ?>">Home</a>
                    </li>
                    <li class="has-child <?php if ($this->uri->segment(1) == 'product') echo 'active' ?>">
                        <a class="arrow" href="javascript:void(0)">Product <span class="arrow"><i style="margin-left: 220px;" class="fa fa-angle-down"></i></span></a>
                        <ul class="dropdown-menu clearfix">
                            <li class="dropdown">
                                <a href="" class="nav-link"><i class="flaticon-open-book"></i>Board</a>
                                <ul class="dropdown-menu clearfix">
                                    <li><a href="" class="nav-link"><i class="flaticon-open-book"></i>Board</a></li>
                                    <li><a href="service-single.html" target="_blank">Audit</a></li>
                                    
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-child <?php if ($current_url == 'details/about-us') echo 'active' ?>">
                        <a href="<?= base_url('details/about-us'); ?>">About Us</a>
                    </li>
                    <li class="has-child <?php if ($current_url == 'details/company-profile') echo 'active' ?>">
                        <a href="<?= base_url('details/company-profile'); ?>">Company Profile</a>
                    </li>
                    <li class="<?php if ($current_url == 'details/contact-us') echo 'active' ?>"><a href="<?= base_url('details/contact-us'); ?>">Contact Us</a></li>
                </ul>
            </nav><!-- .main-menu -->
        </div>
    </div><!-- .header-content -->
</header><!-- .site-header -->

</body>
</html>
