<?php

    namespace twjson;

    use Silex\Application;
    use Silex\ControllerProviderInterface;

    class jsonControllerProvider implements ControllerProviderInterface {

        static public function tweets ( $app, $handle ) {

            /*
             *  https://github.com/J7mbo/twitter-api-php
             *  Set access tokens here - see: https://dev.twitter.com/apps/
             *  URL for REST request, see: https://dev.twitter.com/docs/api/1.1/
             */

            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
            $getfield = "?screen_name=$handle";
            $requestMethod = 'GET';

            $settings = array(
                'consumer_key'              => getenv('apikey'),
                'consumer_secret'           => getenv('apisecret'),
                'oauth_access_token'        => getenv('accesstoken'),
                'oauth_access_token_secret' => getenv('accesstokensecret')
            );

            $twitter = new TwitterAPIExchange( $settings );
            $twitterJSON = json_decode(
                $twitter->setGetfield( $getfield )
                        ->buildOauth( $url, $requestMethod )
                        ->performRequest(),
                true
            );

            return $app->json( $twitterJSON );

        }

        public function connect( Application $app ) {

            $ctr = $app['controllers_factory'];

            $ctr->get( '/', function( Application $app ) {

                return 'you need to provide a twitter handle. Example: <a href="https://twjs.herokuapp.com/syn2cat">https://twjs.herokuapp.com/syn2cat</a>';

            });

            $ctr->get( '/{twitterHandle}', function( Application $app, $twitterHandle ) {

                return self::tweets( $app, $twitterHandle );

            });

            return $ctr;

        }

    }
