<div id="user-profile">
    <!-- profile header -->
    <div class="row">
        <div class="col-12">
            <div class="card profile-header mb-2">
                <!-- profile cover photo -->
                <img class="card-img-top" src="images/profile/user-uploads/timeline.jpg" alt="User Profile Image">
                <!--/ profile cover photo -->

                <div class="position-relative">
                    <!-- profile picture -->
                    <div class="profile-img-container d-flex align-items-center">
                        <div class="profile-img">
                            <img src="{{user_photo}}" class="rounded img-fluid" alt="Card image">
                        </div>
                        <!-- profile title -->
                        <div class="profile-title ml-3">
                            <h2 class="text-white">{{user.first_name}} {{user.last_name}}</h2>
                            <p class="text-white">{{usergroup}}</p>
                        </div>
                    </div>
                </div>


                <!-- tabs pill -->
                <div class="profile-header-nav">
                    <!-- navbar -->
                    <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                        <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i data-feather="align-justify" class="font-medium-5"></i>
                        </button>

                        <!-- collapse  -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
                                <ul class="nav nav-pills mb-0">
                                    <li class="nav-item">
                              
                                    </li>
                                </ul>
                                <!-- edit button -->
                                <button class="btn btn-primary" onclick="vx.$router.push('setting')">
                                    <i data-feather="edit" class="d-block d-md-none"></i>
                                    <span class="font-weight-bold d-none d-md-block">Edit</span>
                                </button>
                            </div>
                        </div>
                        <!--/ collapse  -->
                    </nav>
                    <!--/ navbar -->
                </div>

            </div>
        </div>
    </div>
    <!--/ profile header -->


</div>
<style>
    #user-profile {
        /*-------------profile header section---------*/
        /*-------- profile info section --------*/
    }

    #user-profile .profile-header {
        overflow: hidden;
    }

    #user-profile .profile-header .profile-img-container {
        position: absolute;
        bottom: -2rem;
        left: 2.14rem;
        z-index: 2;
    }

    #user-profile .profile-header .profile-img-container .profile-img {
        height: 8.92rem;
        width: 8.92rem;
        border: 0.357rem solid #FFFFFF;
        background-color: #FFFFFF;
        border-radius: 0.428rem;
        box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
    }

    #user-profile .profile-header .profile-header-nav .navbar {
        padding: 0.8rem 1rem;
    }

    #user-profile .profile-header .profile-header-nav .navbar .navbar-toggler {
        line-height: 0;
    }

    #user-profile .profile-header .profile-header-nav .navbar .profile-tabs .nav-item i,
    #user-profile .profile-header .profile-header-nav .navbar .profile-tabs .nav-item svg {
        margin-right: 0;
    }

    #user-profile #profile-info .profile-star {
        color: #BABFC7;
    }

    #user-profile #profile-info .profile-star i.profile-favorite,
    #user-profile #profile-info .profile-star svg.profile-favorite {
        fill: #FF9F43;
        stroke: #FF9F43;
    }

    #user-profile #profile-info .profile-likes {
        fill: #EA5455;
        stroke: #EA5455;
    }

    #user-profile #profile-info .profile-polls-info .progress {
        height: 0.42rem;
    }

    #user-profile .profile-latest-img {
        -webkit-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
    }

    #user-profile .profile-latest-img:hover {
        -webkit-transform: translateY(-4px) scale(1.2);
        -ms-transform: translateY(-4px) scale(1.2);
        transform: translateY(-4px) scale(1.2);
        z-index: 10;
    }

    #user-profile .profile-latest-img img {
        margin-top: 1.28rem;
    }

    #user-profile .block-element .spinner-border {
        border-width: 0.14rem;
    }

    @media (max-width: 991.98px) {
        #user-profile .profile-latest-img img {
            width: 100%;
        }
    }

    @media (min-width: 768px) {
        .profile-header-nav .profile-tabs {
            width: 100%;
            margin-left: 13.2rem;
        }
    }

    @media (max-width: 575.98px) {
        #user-profile .profile-header .profile-img-container .profile-img {
            height: 100px;
            width: 100px;
        }

        #user-profile .profile-header .profile-img-container .profile-title h2 {
            font-size: 1.5rem;
        }
    }
</style>

<section id="profile-info">
    <div class="row">
        <!-- left profile info section -->
        <div class="col-lg-3 col-12 order-2 order-lg-1">
            <!-- about -->
            <vx-card>
                <vx-card-header title="Infomation"></vx-card-header>
                <vx-card-body>
                    <h5 class="mb-75">About</h5>
                    <div class="mt-2">
                        <h5 class="mb-75">First name:</h5>
                        <p class="card-text">{{user.first_name}}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Last name:</h5>
                        <p class="card-text">{{user.last_name}}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Email:</h5>
                        <p class="card-text mb-0">{{user.email}}</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-50">Phone:</h5>
                        <p class="card-text mb-0">{{user.phone}}</p>
                    </div>
                </vx-card-body>
            </vx-card>
            <!--/ about -->
        </div>
        <!--/ left profile info section -->
    </div>
</section>
<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-08-26 
 */
return new class
{
    function get(VX $vx)
    {
        $this->user = $vx->user;

        $this->user_photo = $vx->user->photo();

        $this->usergroup = collect($vx->user->UserGroup()->toArray())->map(function ($o) {
            return $o->name;
        })->join(", ");
    }
};
