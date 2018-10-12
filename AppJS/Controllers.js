app.controller("Controllers", function ($scope, $http, $log) {


    $scope.init = function () { // Load data on page load first time
        $scope.GetUsers();
        $scope.btnName = "Add User";
    };
    
    $scope.AddUser = function () {
        $http.post(
                "PHPLogics/AddUser.php",
                {'firstname': $scope.first_name, 'lastname': $scope.last_name, 'email': $scope.email, 'mobile': $scope.mobile,'id':$scope.id,'btnName':$scope.btnName}
        ).then(function successCallback(response) {
            
            $scope.first_name = null;
            $scope.last_name = null;
            $scope.email = null;
            $scope.mobile = null;
            $("#UserRegistrationMsg").delay(0).fadeIn();
            $("#UserRegistrationMsg").html(response.data);
            $("#UserRegistrationMsg").delay(3000).fadeOut();
            $scope.btnName = "Add User";
            $scope.GetUsers();
            
        }, function errorCallback(response) {
            alert(response.data);
        });
    };

    $scope.GetUsers = function () {
        $http({
            method: 'get',
            url: 'PHPLogics/GetUsers.php'
        }).then(function successCallback(response) {
            // Store response data
            $scope.users = response.data;
        }, function errorCallback(response) {
            alert(response.data);
        });
    }
    $scope.DeleteUser = function (id) {
        if (confirm("Are you sure ?")) {
            $http({
                method: 'post',
                url: 'PHPLogics/DeleteUsers.php',
                data: {'did': id}
            }).then(function successCallback(response) {
                // Store response data
                $("#UserDetailsMsg").delay(0).fadeIn();
                $("#UserDetailsMsg").html("<div class='alert alert-success'>User is deleted.</div>");
                $("#UserDetailsMsg").delay(3000).fadeOut();
                $scope.GetUsers();
                $scope.users = response.data;

            }, function errorCallback(response) {
                alert(response.data);
            });
        } else {
            return false;
        }
    }
    $scope.UpdateUser = function (id,firstname,lastname,email,mobile) {
        
        $scope.id = id;
        $scope.first_name = firstname;
        $scope.last_name = lastname;
        $scope.email = email;
        $scope.mobile = mobile;
        $scope.btnName = "Update User";
        
    };
    $scope.ResetUser = function () {
        
        $scope.first_name = null;
        $scope.last_name = null;
        $scope.email = null;
        $scope.mobile = null;
        $scope.btnName = "Add User";
        
    };
    $scope.FormValidate = function ($event) {
        $event.preventDefault();
        if($scope.UserForm.$valid){
          $scope.mailRequire = false;
          $scope.firstnameRequire = false;
          $scope.lastnameRequire = false;
          $scope.mobileRequire = false;
          return true;
        }else{
            
          if($scope.UserForm.email.$invalid){
            $scope.mailRequire = true;
          }
          if($scope.UserForm.first_name.$invalid){
            $scope.firstnameRequire = true;
          }
          if($scope.UserForm.last_name.$invalid){
            $scope.lastnameRequire = true;
          }
          if($scope.UserForm.mobile.$invalid){
            $scope.mobileRequire = true;
          }
          return false;
        }
    };

});

