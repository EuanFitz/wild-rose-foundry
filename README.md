This was my final project in my 3rd semester off the interactive Design Web development/design diploma at SAIT, Calgary. Our task as students was to use what we learned in Database programming(MySQL), PHP, JavaScript, HTML, and CSS to create an ecommerce website that automatically populated itself from a database we made. Each page was to be under 1.2mb in size requiring pagination and lazy loading to be used. Each page also had to be responsive from a 300px to a 3000px view width. We were

I approached this project in 4 main phases. 

Phase 1: Creating a database
I made a database diagram to see how each piece of data would interact.
I then populated the database with the 40+ items provided by the instructors.
I made sure all the columns and rows I had were necessary, and made sense

Phase 2: Design   
Using the provided logo for the “Wild Rose Foundry” I chose a pallet that I found acceptable for web use. 
I designed my main elements such as header, footer, buttons, and cards in figma.

Phase 3: Coding
Definitely the largest phase, and can be broken up into 3 sections. 

Section 1: HTML, CSS
Adding all my html elements and populating the page without the use of PHP allowed me to make sure my page was accessible and valid. I ensured every image would have a height and width, alt text, and the pages were responsive. 
Styling is always a hefty process so I tackled this in multiple sessions focusing on one page at a time. 

Section 2: PHP, optimization
The first task was to populate the pages using loops and pulling data from the database.
Once I started pulling all the images I made pagination buttons and limited how many products were displayed per page.
I then ensured all my filters were working allowing users to select specific categories or vendors to view products from.
Next was the cart/order page. I made sure a session was started that would save items that a user put into their cart.
I then populated the users order page with the items and or the variant of the item they wanted to purchase 
I then programmed the order button to send an actual order with the users information to the database so that they could retrieve their order at a later time and the order information was available based of the “order number”
	
	
Section 3: JavaScript
We were tasked with a few different javascript requirements to improve the website
First was a carousel on the home page displaying “featured items” at this point I also made a slight update to the database to account for “featured items”.
I had to make a countdown that reset at midnight every day counting down the days till christmas. I achieved this using the approved Temporal API for calculating time. 
We also had to make it so that clicking on a variant of a product would replace the product image with the variant's image. I used this to also update the variant code that would later get sent to the cart to ensure items in the cart were accurate to what users were choosing 

Phase 4: Testing, Optimizing, Improving
I sent the page to family and friends and asked them to send any issues they had and fixed anything that wasn’t working correctly.
I used photoshop to batch process images to optimize them to ensure smaller page sizes and faster loading speeds.
Spent countless hours tinkering trying to get every aspect perfect. 
I revisited CSS a lot during this phase to make sure everything was perfect and adjusted what wasn’t.
