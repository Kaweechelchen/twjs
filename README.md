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
* set the environment variables for your app
<pre>
    heroku config:set apikey=API_KEY_GOES_HERE
    heroku config:set apisecret=API_SECRET_GOES_HERE
    heroku config:set accesstoken=ACCESS_TOKEN_GOES_HERE
    heroku config:set accesstokensecret=ACCESS_TOKEN_SECRET_GOES_HERE
</pre>
* push the code `git push heroku master`

## License
The MIT License (MIT)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
