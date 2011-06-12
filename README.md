Arduino & Titanium communication via PHP Part 1
=============================================

The Titanium SDK doesn’t natively support serial communication, but I knew the Arduino would be much more valuable to me if I was able to integrate it natively with a desktop app for several reasons:

* With an Arduino I can enhance my ability to add layers of interaction & interface design to my projects.
* The majority of my experience developing comes from web development, Titanium allows me to program in the language of my choice.
* If I could figure out how to connect it, I wouldn’t need to re-write my current app in an app like Processing ( Holy shit, processing is hard ).

There were people out there that were wondering about this same thing, I followed up on the leads they were given and stepped away with something that worked.

For many, The main draw to Titanium is that it will package back-end languages like Pearl, Ruby, or PHP into cross platform applications. With the power of google and these 3 languages we can easily fill whatever “gaps” that titanium may have. Luckily for me, Rémy Sanchez released his class in PHP to communicate with the serial ports on mac + pc + *nix. Using Sanchez’s script as a basis, I started to play with serial communication & PHP the mac.



## Part 1 4/10/11
reads values from the A0 port and displays them in a table. 



## Part 2 5/12/11
currently workign on my mac, uses peity.js plugin to display a graph of the 30 latest values coming in from the A0 port.

* I have it setup to automatically removes the oldest values because peity.js is a memory hog (were talking GB's) when using canvas to display 100+ elements... still not sure why.

 