# my-own-php-cdn

version: 0 alpha

A PHP and Apache driven CDN for statical assets optimized for different devices, would be the technical term. My own personal pride and joy, aka My Own PHP CDN, with all the bells and whistles ever needed so therefore it has to be for free as my saying goes... When doing it properly, when dolving the nitty gritty and polishing all the bits, it has to be for free :D

I'ts gratis!

## Preamble ...

I am not inventing the wheel here, it's already been done and probably with extremely well crafted sollutions aswell. Also the existing CDN's are real CDN's with several servers distributed so that infact they are a CDN by the definition... I will not be, I will be solving the quest for Google PageSpeed 100 ranking and therefore a CDN is needed in all and every website. Since I for some reason want to do it myself so I can proudly state when drinking my beer - I made that! ( and since I didnt want to pay for a service I assume I can so easily make myself, ignoring the fact that I will be using same server and subdomain which is surely a corrupted and perverted view of a CDN, anyway... ). So lets do this, lets make the greatest CDN we can possible make applying best practices for optimal performance. 

## Delivery logic

Flowchart diagram available in different formats:
[draw.io file](https://drive.google.com/file/d/1PNXdQvsSUDCecRG1wNiAMnUm6pyXUhT8/view?usp=sharing)
,
[PNG](/steinhaug/my-own-php-cdn/blob/master/reference/My-Own-PHP-CDN.v1.0.png?raw=true)
,
[SVG](https://raw.githubusercontent.com/steinhaug/my-own-php-cdn/master/reference/My-Own-PHP-CDN.v1.0.svg)
.

![Delivery logic v1.0](https://raw.githubusercontent.com/steinhaug/my-own-php-cdn/master/reference/My-Own-PHP-CDN.v1.0.png "Delivery logic v1.0")

## Requirements and setup

my-own-php-cdn is built on PHP 7 and requires no extra PHP modules, it requires apache and .htaccess with common modules enabled as headers and rewrite. I assume no special attention is needed when setting it up.


## Setup for the main website

Your main domain that needs the CDN needs to reqrite their URLS for their assets. All static files, images, js files, css files etc should be rewritten like this:

Assuming your main domain is: //mysite.com/  
Assuming your CDN domain is: //cdn.mysite.com/

Example of asset in HTML: //mysite.com/images/steinhaug.jpg

This must be rewritten to one of the following (identical parts of the url are striked through for better visualization):

Basic: <a href="//cdn.mysite.com/images/steinhaug.jpg">//cdn.mysite.com ~~/images/steinhaug.jpg~~</a>  
Optimized: <a href="//cdn.mysite.com/mobile/images/steinhaug.jpg">//cdn.mysite.com/devicetype ~~/images/steinhaug.jpg~~</a>  

For the optimized url the devicetype would be either: mobile, tablet or desktop.

## Setup for the CDN site, My Own PHP CDN

To be continued...

## Want to help me out or add your take on the CDN

Follow the discussion at stackexchange if you have any views, information or other related data you think I should be aware of.

[softwareengineering.stackexchange.com question](https://softwareengineering.stackexchange.com/questions/388507/creating-the-perfect-self-populating-cdn-serving-static-optimized-content-from)

## Authors
- [Kim Steinhaug](https://github.com/steinhaug) ([@steinhaug](https://twitter.com/steinhaug))


## License

This plugin is available under the MIT license.
