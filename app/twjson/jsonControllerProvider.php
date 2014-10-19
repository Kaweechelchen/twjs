<?php

    namespace twjson;

    use Silex\Application;
    use Silex\ControllerProviderInterface;

    class jsonControllerProvider implements ControllerProviderInterface {

        static public function getAccount ( $handle ) {

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

        static public function getSearch ( $handle, $sinceId ) {

            /*
             *  https://github.com/J7mbo/twitter-api-php
             *  Set access tokens here - see: https://dev.twitter.com/apps/
             *  URL for REST request, see: https://dev.twitter.com/docs/api/1.1/
             */

            $url = 'https://api.twitter.com/1.1/search/tweets.json';
            $getfield = "?q=$handle%20-RT&count=100&result_type=recent";
            if ( $sinceId != 0 ) {

                $getfield .= "&since_id=$sinceId";

            }
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

        static public function clean( $twitterJSON ) {

            if ( isset( $twitterJSON[ 'statuses' ] )) {

                $twitterJSON = $twitterJSON[ 'statuses' ];

            }

            foreach ( $twitterJSON as $twitterTweet) {

                unset( $tweet );

                $tweet[ 'id'  ] = $twitterTweet[ 'id' ];
                $tweet[ 'uts' ] = strtotime( $twitterTweet[ 'created_at' ] );
                $tweet[ 'txt' ] = $twitterTweet[ 'text' ];
                $tweet[ 'user' ][ 'handle' ]    = $twitterTweet[ 'user' ][ 'screen_name' ];
                $tweet[ 'user' ][ 'name' ]    = $twitterTweet[ 'user' ][ 'name' ];
                $tweet[ 'user' ][ 'profilePic' ] = str_replace(
                    '_normal',
                    '',
                    $twitterTweet[ 'user' ][ 'profile_image_url_https' ]
                );

                if( array_key_exists( 'extended_entities', $twitterTweet ) ) {

                    foreach ( $twitterTweet[ 'extended_entities' ][ 'media' ] as $image ) {

                        $tweet[ 'img' ][] = $image[ 'media_url_https' ];

                    }

                } else if ( array_key_exists( 'media', $twitterTweet[ 'entities' ] ) ){

                    foreach ( $twitterTweet[ 'entities' ][ 'media' ] as $image ) {

                        $tweet[ 'img' ][] = $image[ 'media_url_https' ];

                    }

                }

                $tweets[] = $tweet;

            }

            array_slice($tweets, 1, 1, true);

            return $tweets;

        }

        public function connect( Application $app ) {

            $ctr = $app['controllers_factory'];

            $ctr->get( '/', function( Application $app ) {

                return 'you need to provide a twitter handle. Example: <a href="https://twjs.herokuapp.com/syn2cat">https://twjs.herokuapp.com/syn2cat</a>';

            });

            $ctr->get( '/search/{twitterHandle}/{sinceId}', function( Application $app, $twitterHandle, $sinceId ) {

                $tweets = self::getSearch( $twitterHandle, $sinceId );

                return $app->json( $tweets );

            })->value('sinceId', 0);

            $ctr->get( '/clean/search/{twitterHandle}/{sinceId}', function( Application $app, $twitterHandle, $sinceId ) {

                $tweets = self::clean(
                    self::getSearch( $twitterHandle, $sinceId )
                );

                return $app->json( $tweets );

            })->value('sinceId', 0);

            $ctr->get( '/clean/{twitterHandle}', function( Application $app, $twitterHandle ) {

                $tweets = self::clean(
                    self::getAccount( $twitterHandle )
                );

                return $app->json( $tweets );

            });

            $ctr->get( '/{twitterHandle}', function( Application $app, $twitterHandle ) {

                $tweets = self::getAccount( $twitterHandle );

                return $app->json( $tweets );

            });

            return $ctr;

        }

    }
