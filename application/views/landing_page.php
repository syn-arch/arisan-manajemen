<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E POS</title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url() ?>node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= base_url() ?>node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light border-bottom fixed-top">
        <div class="container py-2">
            <a class="navbar-brand fw-bold" href="#home">EPOS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="me-auto"></div>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#whychoiceus">WHY CHOICE US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">PRICING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">TESTIMONIALS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">CONTACT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-pink text-white px-4" href="<?= base_url('login') ?>">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- home -->
    <div class="container home" id="home">
        <div class="row">
            <div class="col-md-6">
                <h1 class="fw-bold my-heading">BOOST YOUR SALES NOW, WHAT ARE YOU WAITING FOR!</h1>
                <p>Increase your sales by using our application, feel the ease and comfort of managing your sales by tracking expense and income reports automatically</p>
                <div class="home-button mt-4">
                    <a href="#whychoiceus" class="btn btn-pink text-white px-5 py-2 mr-3 mt-2 btn-pink-block">DISCOVER
                    </a>
                    <a href="#subscribe" class="btn btn-outline-pink text-white px-5 py-2 mt-2 btn-pink-block">GET PROMO
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="<?= base_url() ?>assets/img/home.svg" alt="" class="img-fluid mt-3">
            </div>
        </div>
    </div>
    <!-- end home -->

    <!-- subscribe -->
    <div class="subscribe mt-5 py-5" id="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-white fw-bold">SUBSCRIBE OUR NEWSLETTER</h3>
                    <p class="subscribe-text">subscribe to get promos and interesting things from us, without spam we promise.</p>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <form class="form-subscribe">
                        <div class="form-group">
                            <input type="text" class="form-input-group" placeholder="yourmail@example.com">
                            <button class="form-button-group">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end subscribe -->

    <!-- why choice us -->
    <div class="whychoiceus mt-5" id="whychoiceus">
        <div class="container">
            <h4 class="text-center">WHY CHOICE US</h4>
            <p class="text-center text-gray">Customer satisfaction is the most important thing for us.</p>
            <div class="row mt-5">
                <div class="col-sm-6">
                    <div class="card-wcu float-end">
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-left">
                                <i class="fa fa-check fa-4x wcu-card-icon"></i>
                            </div>
                            <div class="col-md-9 wcu-card-body">
                                <h5 class="fw-bold wcu-card-title">TRUSTED BY MANY COMPANIES</h5>
                                <p class="text-gray">Many companies entrust their sales application needs to us</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card-wcu">
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-left">
                                <i class="fa fa-clock fa-4x wcu-card-icon"></i>
                            </div>
                            <div class="col-md-9 wcu-card-body">
                                <h5 class="fw-bold wcu-card-title">BOOST YOUR TRANSACTION PRODUCTIVITY</h5>
                                <p class="text-gray">By using shortcuts in our application you can make sales transactions faster</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 wcu-second">
                <div class="col-sm-6">
                    <div class="card-wcu float-end">
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-left">
                                <i class="fa fa-signal fa-3x wcu-card-icon"></i>
                            </div>
                            <div class="col-md-9 wcu-card-body">
                                <h5 class="fw-bold wcu-card-title">BOOST YOUR INCOME IN FEW MONTH</h5>
                                <p class="text-gray">Feel a significant increase in sales with this application</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card-wcu">
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-left">
                                <i class="fa fa-box fa-4x wcu-card-icon"></i>
                            </div>
                            <div class="col-md-9 wcu-card-body">
                                <h5 class="fw-bold wcu-card-title">MANAGE STOK WITH VERY EASY</h5>
                                <p class="text-gray">Arrange stock in several stores at once and get the report</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end why choice us -->

    <!-- pricing -->
    <div class="pricing mt-5" id="pricing">
        <div class="container">
            <h4 class="text-center">PRICING</h4>
            <p class="text-center text-gray">Determine the progress of your shop now</p>
            <div class="row mt-5">
                <div class="col-md-4 mt-4">
                    <div class="pricing-card text-center pt-2 pb-4">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="pricing-badge fw-bold my-3 py-2">
                                    <span>BASIC</span>
                                </div>
                                <h2 class="pricing-price fw-bold my-4">
                                    $35
                                </h2>
                                <span class="text-muted">ONCE PAYMENT</span>
                                <ul class="list-group list-group-flush mt-4">
                                    <li class="list-group-item"><i class="fa fa-check"></i> Track sales report</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Stock management</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Customer management</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Sales & Purchase</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Debt & Accounts receivable</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Offline and online</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Fees transaction</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Much more</li>
                                </ul>
                                <div class="mt-3">
                                    <a href="" class="button-order py-2 px-5">ORDER NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="pricing-card pricing-card-middle text-white text-center pt-2 pb-4">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="pricing-badge pricing-badge-middle fw-bold my-3 py-2">
                                    <span>STANDARD</span>
                                </div>
                                <h2 class="pricing-price fw-bold my-4">
                                    $35
                                </h2>
                                <span class="text-dark">ONCE PAYMENT</span>
                                <ul class="list-group list-group-middle list-group-flush mt-4">
                                     <li class="list-group-item"><i class="fa fa-check"></i> Track sales report</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Stock management</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Customer management</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Sales & Purchase</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Debt & Accounts receivable</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Offline and online</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Fees transaction</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Much more</li>
                                </ul>
                                <div class="mt-3">
                                    <a href="" class="button-order py-2 px-5">ORDER NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="pricing-card text-center pt-2 pb-4">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="pricing-badge fw-bold my-3 py-2">
                                    <span>PRO</span>
                                </div>
                                <h2 class="pricing-price fw-bold my-4">
                                    $35
                                </h2>
                                <span class="text-muted">ONCE PAYMENT</span>
                                <ul class="list-group list-group-flush mt-4">
                                    <li class="list-group-item"><i class="fa fa-check"></i> Track sales report</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Stock management</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Customer management</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Sales & Purchase</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Debt & Accounts receivable</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Offline and online</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Fees transaction</li>
                                    <li class="list-group-item"><i class="fa fa-check"></i> Much more</li>
                                </ul>
                                <div class="mt-3">
                                    <a href="" class="button-order py-2 px-5">ORDER NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end pricing -->

    <!-- testimonials -->
    <div class="testimonials mt-5" id="testimonials">
        <div class="container">
            <h4 class="text-center">TESTIMONIALS</h4>
            <p class="text-center text-gray">What are they saying?</p>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        <div class="testimonial-card text-center py-3 px-4 mx-3 mb-5 mt-4">
                            <img src="<?= base_url() ?>assets/img/man.png" alt="man" class="testimonial-img">
                            <p class="testimonial-text mt-3">
                                Wow..this application really helps my sales, very easy to operate
                            </p>
                            <span class="text-muted float-right">Beverly Hunter</span>
                        </div>
                        <div class="testimonial-card text-center py-3 px-4 mx-3 mb-5 mt-4">
                            <img src="<?= base_url() ?>assets/img/man.png" alt="man" class="testimonial-img">
                            <p class="testimonial-text mt-3">
                                With this application I can easily manage stock in several of my store branches without the hassle
                            </p>
                            <span class="text-muted float-right">Gwendolyn Mckinney</span>
                        </div>
                        <div class="testimonial-card text-center py-3 px-4 mx-3 mb-5 mt-4">
                            <img src="<?= base_url() ?>assets/img/man.png" alt="man" class="testimonial-img">
                            <p class="testimonial-text mt-3">
                                Since using this application I have not used manual note-taking using books
                            </p>
                            <span class="text-muted float-right">Allen Ramos</span>
                        </div>
                        <div class="testimonial-card text-center py-3 px-4 mx-3 mb-5 mt-4">
                            <img src="<?= base_url() ?>assets/img/man.png" alt="man" class="testimonial-img">
                            <p class="testimonial-text mt-3">
                                accounts payable and accounts receivable records are well organized, I can easily manage them
                            </p>
                            <span class="text-muted float-right">Robin Lynch</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end testimonials -->

    <!-- contact -->
    <div class="contact mt-5" id="contact">
        <div class="container">
            <h4 class="text-center">GET IN TOUCH</h4>
            <p class="text-center text-gray">Feel free to contact us</p>
            <div class="row mt-5">
                <div class="col-md-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242999!2d107.57311651061447!3d-6.903273916949621!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1608285918365!5m2!1sen!2sid"
                        width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe>
                    <h5 class="fw-bold mt-3">MY STUDIO</h5>
                    <p>Jl. Soekarno Hatta no.69</p>
                    <h5 class="fw-bold mt-3">CONNECT WITH US</h5>
                    <i class="mr-2 fab fa-facebook fa-2x"></i>
                    <i class="mx-2 fab fa-instagram fa-2x"></i>
                    <i class="mx-2 fab fa-youtube fa-2x"></i>
                    <i class="mx-2 fab fa-telegram fa-2x"></i>
                </div>
                <div class="col-md-6">
                    <div class="contact-form p-5">
                        <h4 class="fw-bold">CONTACT US</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control form-input-grey" placeholder="your name">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control form-input-grey"
                                    placeholder="yourmail@example.com">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <textarea name="message" id="message" cols="30" rows="10"
                                    class="form-control form-input-grey" placeholder="your message"></textarea>
                                <button type="submit" class="button-order btn-submit-form py-2 mt-3">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end contact -->

    <!-- footer -->
    <footer class="mt-5">
        <div class="container text-white">
            <div class="row py-5">
                <div class="col-md-4">
                    <h4>E POS</h4>
                    <p>Point of sales appication, trusted by more than 100+ retailer in Bandung</p>
                </div>
                <div class="col-md-2 offset-md-3">
                    <h5>QUICK LINKS</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-white">Home</a></li>
                        <li><a href="#whychoiceus" class="text-white">Why Choice Us</a></li>
                        <li><a href="#pricing" class="text-white">Pricing</a></li>
                        <li><a href="#testimonials" class="text-white">Testimonials</a></li>
                        <li><a href="#contact" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h5>SOCIAL MEDIA</h5>
                    <ul class="list-unstyled">
                        <li><a href="" class="text-white">Facebook</a></li>
                        <li><a href="" class="text-white">Youtube</a></li>
                        <li><a href="" class="text-white">Instagram</a></li>
                        <li><a href="" class="text-white">Whatsapp</a></li>
                        <li><a href="" class="text-white">Telegram</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

</body>

<script src="<?= base_url() ?>node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() ?>node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/app.js"></script>

</html>
