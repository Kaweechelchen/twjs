twjs
====

Gathering twitter timelines as json without the oAuth fuzz

##API

**[<code>GET</code> TWITTER_HANDLE](https://twjs.herokuapp.com/syn2cat)**

## Example

    https://twjs.herokuapp.com/syn2cat

##Installation on your own heroku instance

1. Clone this repository using `git clone git@github.com:Kaweechelchen/twjs.git`
* Get an [Heroku account](https://id.heroku.com/signup)
* install the [heroku toolbelt](https://toolbelt.heroku.com/)
* create a new heoku app using `heroku create`
* Create a [new Twitter application](https://apps.twitter.com/app/new) and get API keys
* set the environment variables for your app
<pre>
    heroku config:set apikey=API_KEY_GOES_HERE
    heroku config:set apisecret=API_SECRET_GOES_HERE
    heroku config:set accesstoken=ACCESS_TOKEN_GOES_HERE
    heroku config:set accesstokensecret=ACCESS_TOKEN_SECRET_GOES_HERE
</pre>
* push the code `git push heroku master`

## Twitter API handler

I got some code from [James Mallison](https://github.com/j7mbo) https://github.com/j7mbo/twitter-api-php

## License
Copyright (c) 2014 [Thierry Degelings](https://github.com/Kaweechelchen)
Licensed under the MIT license.
