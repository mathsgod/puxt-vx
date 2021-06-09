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
return [
    "page" => [
        "header" => [
            "title" => "Profile"
        ]
    ], "get" => function (VX $context) {

        $this->user = $context->user;

    }
];
