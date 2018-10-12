/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app.controller("CartController", function ($scope, $http) { 
    $scope.CartItems = [];
    $scope.init = function () { // Load data on page load first time
        $scope.getProducts();
        $scope.getCount();
        $scope.getCartItems();
    };
    $scope.getProducts = function () {
        $http({
            method: 'get',
            url: 'PHPLogics/getProducts.php'
        }).then(function successCallback(response) {
            // Store response data
            $scope.products = response.data;
        }, function errorCallback(response) {
            alert(response.data);
        });
    };
    $scope.getCount = function () {
        $http({
            method: 'get',
            url: 'PHPLogics/ProductCount.php'
        }).then(function successCallback(response) {
            // Store response data
            if(response.data > 0){
                $scope.count = response.data;
            }else{
                $scope.count = 0;
            }
        }, function errorCallback(response) {
            alert(response.data);
        });
    };
    
    $scope.getCartItems = function () {
        $http({
            method: 'get',
            url: 'PHPLogics/getCartItems.php'
        }).then(function successCallback(response) {
            // Store response data
            if(response.data === 0){
                $("#CartDetails").html("<tr><td colspan='5'>Cart is empty.</td></tr>");
            }else{
                $scope.CartItems = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
        });
    };
    $scope.AddToCart = function (id) {
        $http.post(
                "PHPLogics/AddToCart.php",
                {'ProductId': id }
        ).then(function successCallback(response) {
            // Store response data
            $scope.init();
        }, function errorCallback(response) {
            alert(response.data);
        });
    };
    $scope.RemoveFromCart = function (id) {
        if(confirm("Are you sure !")){
            $http.post(
                    "PHPLogics/RemoveFromCart.php",
                    {'ProductId': id }
            ).then(function successCallback(response) {
                // Store response data
                $scope.init();
            }, function errorCallback(response) {
                alert(response.data);
            });
        }else{
            return false;
        }
    };
    $scope.getCartTotal = function () {
        
        var total = 0;
        for (var i = 0; i < $scope.CartItems.length; i++){
            var product = $scope.CartItems[i];
            total += parseFloat(product.Amount);
        }
        return total;
    };
});




