var app = angular.module('app', [
    'ui.router',
    'ngCookies',
//    'ngRoute',      //$routeProvider
    'mgcrea.ngStrap', //bs-navbar, data-match-route directives
    'controllers'       //Our module /web/js/controllers.js
]);

app.config(function($stateProvider, $urlRouterProvider) {
    $stateProvider
    .state({
        name: 'home',
        url: '/',
        templateUrl: 'partials/index.html'
    })
    .state({
        name: 'login',
        url: '/login',
        templateUrl: 'partials/login.html',
        controller: 'LoginController'
    })
    .state({
        name: 'contact',
        url: '/contact',
        templateUrl: 'partials/contact.html',
        controller: 'ContactController'
    })
    .state({
        name: 'dashboard',
        url: '/dashboard',
        templateUrl: 'partials/dashboard.html',
        controller: 'DashboardController'
    })
    .state({
        name: 'about',
        url: '/about',
        templateUrl: 'partials/about.html'
    })
    .state({
        name: '404',
        url:'/404',
        templateUrl: 'partials/404.html'
    });

    $urlRouterProvider.otherwise('/');
});/*.run(['$rootScope', '$transitions', '$state', '$cookies', '$http', 'AuthService',
    function ($rootScope, $transitions, $state, $cookies, $http, AuthService) {

        // keep user logged in after page refresh
        $rootScope.globals = $cookies.get('globals') || {};
        $http.defaults.headers.common['Authorization'] = 'Bearer ' + $rootScope.globals;

        $transitions.onStart({
            to: function (state) {
                return state.data != null && state.data.authRequired === true;
            }
        }, function () {
            if (!AuthService.isAuthenticated()) {
                return $state.target("login");
            }
        });
    }]);*/

// this uses ngRoute
/*app.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'partials/index.html',
            }).
            when('/about', {
                templateUrl: 'partials/about.html'
            }).
            when('/contact', {
                templateUrl: 'partials/contact.html',
                controller: 'ContactController'
            }).
            when('/login', {
                templateUrl: 'partials/login.html',
                controller: 'LoginController'
            }).
            when('/signup', {
                templateUrl: 'partials/signup.html',
                controller: 'SignupController'
            }).
            when('/dashboard', {
                templateUrl: 'partials/dashboard.html',
                controller: 'DashboardController'
            }).
            otherwise({
                templateUrl: 'partials/404.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);*/

app.factory('authInterceptor', function ($q, $window, $location) {
    return {
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                //HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            return config;
        },
        responseError: function (rejection) {
            if (rejection.status === 401) {
                $location.path('/login').replace();
            }
            return $q.reject(rejection);
        }
    };
});

/*app.factory('AuthService',
    ['$http', '$cookies', '$rootScope',
        function ($http, $cookies, $rootScope) {
            var service = {};

            // Authenticates throug a rest service
            service.authenticate = function (username, password, callback) {

//                $http.post('api/login', {username: username, password: password})
//                        .success(function (response) {
//                            callback(response);
//                        });
                $http({
                    method: 'POST',
                    url:'api/login',
                    username: username, 
                    password: password
                }).then(function (response) {
                            callback(response);
                        }, function(response){
                            callback(response);
                        });
            };

            // Creates a cookie and set the Authorization header
            service.setCredentials = function (response) {
                $rootScope.globals = response.token;

                $http.defaults.headers.common['Authorization'] = 'Bearer ' + response.token;
                $cookies.put('globals', $rootScope.globals);
            };

            // Checks if it's authenticated
            service.isAuthenticated = function() {
                return !($cookies.get('globals') === undefined);
            };

            // Clear credentials when logout
            service.clearCredentials = function () {
                $rootScope.globals = undefined;
                $cookies.remove('globals');
                $http.defaults.headers.common.Authorization = 'Bearer ';
            };

            return service;
        }]);
 */