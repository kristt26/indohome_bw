<!DOCTYPE html>
<html lang="en" ng-app="apps">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/login.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>

<body ng-controller="loginController">
    <div class="main">
        <div class="container">
            <center>
                <div class="middle">
                    <div id="login">
                        <form ng-submit="login()">
                            <fieldset class="clearfix">
                                <p><span class="fa fa-user"></span><input type="text" Placeholder="Username" ng-model="model.username" required></p> <!-- JS because of IE support; better: placeholder="Username" -->
                                <p><span class="fa fa-lock"></span><input type="password" Placeholder="Password" ng-model="model.password" required></p> <!-- JS because of IE support; better: placeholder="Password" -->
                                <div>
                                    <span style="width:48%; text-align:left;  display: inline-block;"><a class="small-text" href="<?= base_url("auth/register") ?>">Create Account?</a></span>
                                    <span style="width:50%; text-align:right;  display: inline-block;"><input type="submit" value="Sign In"></span>
                                </div>
                            </fieldset>
                            <div class="clearfix"></div>
                        </form>
                        <div class="clearfix"></div>
                    </div> <!-- end login -->
                    <div class="logo">
                        <img src="<?= base_url() ?>assets/assets/img/logo.png" width="100%" alt="">
                        <div class="clearfix"></div>
                    </div>

                </div>
            </center>
        </div>

    </div>
    <script src="<?= base_url() ?>/assets/js/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/libs/angular/angular.min.js"></script>
    <script src="<?= base_url() ?>/js/services/helper.services.js"></script>
    <script src="<?= base_url() ?>/js/services/pesan.services.js"></script>
    <script src="<?= base_url() ?>/libs/loading/dist/loadingoverlay.min.js"></script>
    <script src="<?= base_url() ?>/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script>
        angular.module('apps', ['message.service', 'helper.service'])
            .controller("loginController", loginController);

        function loginController($scope, $http, pesan, helperServices) {
            $scope.model = {};
            $scope.map = false;
            $scope.login = () => {
                $.LoadingOverlay('show');
                $http({
                    method: "post",
                    url: helperServices.url + "auth/login",
                    data: $scope.model,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(res => {
                    document.location.href = helperServices.url + "beranda";
                }, err => {
                    pesan.error(err.data.messages.error);
                });
            }
        }
    </script>
</body>

</html>