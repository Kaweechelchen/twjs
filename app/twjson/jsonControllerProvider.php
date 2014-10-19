<?php

    namespace twjson;

    use Silex\Application;
    use Silex\ControllerProviderInterface;

    class jsonControllerProvider implements ControllerProviderInterface {

        static public function account ( $handle ) {

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

            return ( $twitterJSON );

        }

        static public function getAccount( $app, $handle ) {

            return $app->json( self::account( $handle ) );

        }

        static public function getCleanAccount( $app, $handle) {

            $twitterJSON = self::account( $handle );

            foreach ( $twitterJSON as $twitterTweet) {

                unset( $tweet );

                $tweet[ 'uts' ] = strtotime( $twitterTweet[ 'created_at' ] );
                $tweet[ 'txt' ]   = $twitterTweet[ 'text' ];

                if( array_key_exists( 'extended_entities', $twitterTweet ) ) {

                    foreach ( $twitterTweet[ 'extended_entities' ][ 'media' ] as $image ) {

                        $tweet[ 'img' ][] = $image[ 'media_url_https' ];

                    }

                }

                $tweets[] = $tweet;

            }

            array_slice($tweets, 1, 1, true);

            return $app->json( $tweets );

        }

        public function connect( Application $app ) {

            $ctr = $app['controllers_factory'];

            $ctr->get( '/', function( Application $app ) {

                return 'you need to provide a twitter handle. Example: <a href="https://twjs.herokuapp.com/syn2cat">https://twjs.herokuapp.com/syn2cat</a>';

            });

            $ctr->get( '/clean/{twitterHandle}', function( Application $app, $twitterHandle ) {

                return self::getCleanAccount( $app, $twitterHandle );

            });

            $ctr->get( '/{twitterHandle}', function( Application $app, $twitterHandle ) {

                return self::getAccount( $app, $twitterHandle );

            });

            return $ctr;

        }

    }
