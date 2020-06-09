var app = angular.module('app', [
    'ui.router',
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
});

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