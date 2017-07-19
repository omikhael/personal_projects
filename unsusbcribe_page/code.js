/*
    short game
    practice if/else statments
    displaying messages to the user (confirm) (console.log)
    getting info from user (prompt)
*/
// Check if the user is ready to play!
confirm("I am ready to play");
//set age variable based on answer of the user
var age = prompt("What's your age?");
/*
    check if the user's age is under 13
    if yes, the user is allowed to play, need parents
    if no, the user is encouraged to play
*/
if(age < 13){
    console.log("You are allowed to play, but you need parantel approval");
} else {
    console.log("Play on! you are of age to play safely.");
}
//game story line
console.log("You are at a Justin Bieber concert, and you hear this lyric 'Lace my shoes off, start racing.'");
//continue game story line
console.log("Suddenly, Bieber stops and says, 'Who wants to race me?'");
//set userAnswer variable based on answer of the user
var userAnswer = prompt("Do you want to race Bieber on stage?");
/*
    display messages based on user's answer
    if yes, display message 1
    if no, display message 2
*/
if(userAnswer == "yes"){
    console.log("You and Bieber start racing. It's neck and neck! You win by a shoelace!");
} else {
    console.log("Oh no! Bieber shakes his head and sings 'I set a pace, so I can race without pacing.'");
}
/*
    set userAnswer variable and value is based on 
    answer of the user
*/
var feedback = prompt("Please rate the game out of 10");
/*
    display messages based on feedback answer from user
    if greater than 8, display message 1
    if not greater than 8, display message 2
*/
if(feedback > 8){
    console.log("Thank you! We should race at the next concert!");
} else {
    console.log("I'll keep practicing coding and racing.");
}

//////////////////////////////////////////////////////

/*
    function to do calculations using length and width params
    gets length and width params
        returns the results of calculation
    call the function with values to the params
*/
var perimeterBox = function(length, width){
    return length * 2 + width * 2;
};
perimeterBox(3, 4);

///////////////////////////////////////////////////////////

/*
    function to determain if user's is getting good sleep
    set numHours variable to get the value of hours from user ask 
    function gets one param (numHours)
    if numHours is equal or more than 8 hours
        then display message1
    else if numHours is less than 8 hours
        then display message2
    call the function and pass it the value from the user
*/
var numHours = prompt("How many hours of sleep did you have?");
var sleepCheck = function(numHours){
    if(numHours >= 8){
        return "You're getting plenty of sleep! Maybe even too much!";
    } else if (numHours < 8){
        return "Get some more shut eye!";
    }
};
sleepCheck(numHours);

//////////////////////////////////////////////////////

/*
    Game: paper, rock, scissors
    practice use of functions
    practice use of if/else and inner else if statements
    practice use of getting values from users (prompt)
    use Math.random() function
    calling functions
    printing to user (console.log)
*/
var rpsGame = function(){
    //set variable userChoice, get value from user 
    var userChoice = prompt("Do you choose rock, paper or scissors?");
    /*
        function gets userChoice (checks user input)
        set array called choices
        for each variable in choices
            check if the input is in choices
                if yes, then return the userChoice input (its valid)
            else return a message for the user to enter correct input
        set the userChoice to the return value of the function
    */
    var choices = ["rock", "paper", "scissors"];
    var checkInput = function(userChoice) {
    for(var i in choices) {
        if(userChoice === choices[i]) {
            return userChoice;
        }
    }
        return prompt("Wrong choice! Please enter Rock or Paper or Scissors.");
    };
    userChoice = checkInput(userChoice);
    //display userChoice value
    console.log("User: " + userChoice);
    //set variable computerChoice, use Math.random()
    var computerChoice = Math.random();
    /*
        Set paper,rock, sciessor values based on random computerChoice
        if computerChoice is less than 0.34
            then value is rock
        else if computerChoice is equal or less than 0.67
            then value is paper
        elese
            compusterChoice is scissors
    */
    if (computerChoice < 0.34) {
        computerChoice = choices[0];
    } else if(computerChoice <= 0.67) {
        computerChoice = choices[1];
    } else {
        computerChoice = choices[2];
    } 
    //display computerChoice value
    console.log("Computer: " + computerChoice);
    /*
        function to determain winners of the game 
        based on two paramps (choice1, choice2):
        if choice1 equals choice2
            display its a tie to the user 
            user needs to play again
            rerun the game 
        else if choice1 is rock
            if choice2 is scissors
                then rock wins (choice1)
            else paper wins (choice2)
        else if choice1 ia paper
            if choice2 is rock
                then paper wins (choice1)
            else scissors wins (choice2)
        else if choice1 is scissors
            if choice2 is rock
                then rock wins (choice2)
            else scissors wins (choice1)
    */
    var compare = function(choice1, choice2, choices){
        if(choice1 === choice2){
            console.log("game is a tie, please play again!"); 
            console.log("-----------------------");    
            return rpsGame();
        } else if(choice1 === choices[0]){
            if(choice2 === choices[2]){
                return choices[0] + " wins";
            } else {
                return choices[1] + " wins";
            }
        } else if(choice1 === choices[1]){
            if(choice2 === choices[0]){
                return choices[1] + " wins";
            } else {
                return choices[2] + " wins";
            }
        } else if(choice1 === choices[2]){
            if(choice2 === choices[0]){
                return choices[0] + " wins";
            } else {
                return choices[2] + " wins";
            }
        }
    };
    //return the compare function with values for params (userChoice, compusterChoice)
    return compare(userChoice, computerChoice, choices);
};
//run the rpsGame function
rpsGame();

//////////////////////////////////////////////////////

/*
    Practicing arrays and for loops
*/
var names = ["Olivia", "Mina", "Ashraf", "Sanaa", "Mikhael"];

for(var i = 0; i < names.length; i++){
    console.log("I know someone called " + names[i]);
}

/////////////////////////////////////////////////////
/*
    Practicing arrays and for loops to search for specific words/letters
*/
/*jshint multistr:true */
var text = "hello hey hey hey olivia hey hey hey hey hey \
hey hey hey hey oliver hey hey hey olivia hey hey hey";
var myName = "olivia";
var hits = []

for (var i = 0; i < text.length; i++)
{
    if(text[i] === "o"){
        for(var j = i; j < (myName.length + i); j++){
             if (text.substring(i, (myName.length + i)) === myName)
           {
                hits.push(text[j])
           }
        }    
    }
}

if(hits.length === 0){
    console.log("Your name wasn't found!");
} else {
    console.log(hits);
}

/*
used regex for the same work
*/
/*jshint multistr:true */
var text = "hello hey hey hey olivia hey hey hey hey \ 
hey hey hey hey hey oliver hey hey hey olivia hey \ 
hey  hey";

var hits = text.match(/olivia/g);

if (hits.length === 0) {
    console.log("No matches found.");
} else {
    console.log(hits);
}

/*
 global without the need to specifying the name 
 depends on what user enters
*/
/*jshint multistr:true */
var name = prompt("what is your name?");

var text = "My name is " + name + ". " 
            + name + " lives in Canada";
var hits = [];
var regexp = new RegExp(name, "g");
var match;
while (match = regexp.exec(text)) {
    hits.push(match[0]);
}
console.log(hits);

///////////////////////////////////////

/*
  Different types of loops
*/

// Write your code below!
for(i = 5; i <21; i += 5){
    console.log("For loop print numbers: " + i);
}

console.log("-------------");

var condition = false;
do{
    console.log("Print once for do/while loop!");
}while(condition)

console.log("-------------");

var number = 5;
while(number < 25){
    console.log("While loop print numbers: " + number);
    number += 5;
}

///////////////////////////////////////////

/*
  Dragon slaying game
  control flow syntax
*/
//set condition to true
var slaying = true;
//set random range between 0 or 1 (false/true)
var youHit = Math.floor(Math.random() * 2);
//set random range between 1 and 5
var damageThisRound = Math.floor(Math.random() * 5 + 1);
//initialize total damage
totalDamage = 0;

//while the condition is set to slaying
//the game continues
while(slaying)
{
    //if a hit was made
    // then display a positive message
    //else display a negative message
    if(youHit){
        console.log("You hit!");        
        totalDamage += damageThisRound;
        //check if the total damage is equal or more than 4
        // if yes then the player has one and the game stops
        //else assign a new random number of hit between 0/1 (false/true)
        if(totalDamage >= 4){
            console.log("You won!");
            slaying = false; 
        } else {
            youHit = Math.floor(Math.random() * 2);
        }
    } else {
        console.log("You lose!");
        //set slaying got false 
        slaying = false; 
    }
}

////////////////////////////////////////////
/*
  calculate for even numbers
  control flow syntax
*/

var number = prompt("Enter a number.");

var isEven = function(number) {
  // Your code goes here!
  if(number % 2 === 0){
      return true;
  } else if(isNaN(number)){
      return "Not a number.";
  } else {
      return false;
  }
};

isEven(number);

//////////////////////////////////////////

/*
  switch syntax
*/

// Write your code below!
var music = prompt("What is your favorite music?", "enter music here");

switch(music){
    case 'rock':
        console.log("you like it hard, ay!");
        break;
    case 'rap':
        console.log("so gangster!");
        break;
    case 'pop':
        console.log("fun and easy!");
        break;
    default:
        console.log("don't have a favorite music!");
}
//logical operators
//or
true || true;     // => true
true || false;    // => true
false || true;    // => true
false || false;   // => false
//and
true && true;    // => true
true && false;   // => false
false && true;   // => false
false && false;  // => false
//not
!true;   // => false
!false;  // => true

///////////////////////////////////

/*
  slay dragon game!
*/

var user = prompt("Going on a journy and you meet an angry dragon, do you 'slay' or 'run' from or 'calm' the dragon?", "enter your choice here").toLowerCase();

switch(user){
    case 'slay':
        console.log("You are a brave person!");
        var tool = prompt("Do you have a sord?", "enter 'yes' or 'no'").toLowerCase();
        var strategy = prompt("Do you have a strategy?", "enter 'yes' or 'no'").toLowerCase();
        if(tool === "yes" && strategy === "yes"){
            console.log("Congratulations, you won! with your sword and strategy you slayed the dragon.");
        } else {
            console.log("Oh no, you lose! you need both to be able to slay the dragon - better run fast!");
        }
        break;
    case 'run':
        console.log("You are a smart person!");
        var speed = prompt("Are you fast?", "enter 'yes' or 'no'").toLowerCase();
        var hide = prompt("Do you know how to hide well?", "enter 'yes' or 'no'").toLowerCase();
        if(speed === "yes" || hide === "yes"){
            console.log("You saved yourself! you only needed one of the skills");
        } else {
            console.log("You're defeated! got caught by the dragon");
        }
        break;
    case 'calm':
        console.log("You are a kind person, congrats the dragon is now your bet!");
        break;
    default:
        console.log("Please hit run and enter either 'slay' or 'run' or 'calm'.");
        
}

//////////////////////////////////

//multidimentional array , heterogenous arrays (has different types of values int str boolean)
var newArray = [[26, "Olivia", "Female"], [55, true,"JavaScript"], ["swimming", true, "Average"]];

console.log(newArray);

//jagged arrays
var jagged = [[26, "olivia", "female", true], ["JavaScript"]];

console.log(jagged);

///////////////////////////////////

//object literal notation  (MORE PREFERED IN PROGRAMMING) - object with keys and values
var me = {
    name: 'Olivia',
    age: 26,
    gendre: 'female'
}

//object constructor
var me = new Object();

//both me["name"] and me.name are the same different way of writing
me["name"] = "olivia";
me.age = 16;
me.gendre = "female";

//heterogenous array 
//boolean
var choice = true;
//object
var myObject = {
    type : 'string',
    description : 'hello world!'
};
//array contains all different types of values
var myArray = [30, choice, "max age", myObject];
//print code
console.log(myArray);

////////////////////////////////////////

/*
  list log of friends
  displays info based on which name was entered
  objects contain properties within its {}
*/

var friends = {};
friends.Bill = {
    firstName: 'Bill',
    lastName: 'Ali',
    number: '(234) 234-5677',
    address: ['23 Elmond Street', 'Kitchener', 'ON', '2D3 N4D']
};
friends.Steve = {
    firstName: 'Steve',
    lastName: 'Edwards',
    number: '(534) 234-8888',
    address: ['45 Yoyo Avenue', 'Cambridge', 'ON', '24G3 M2F']
};
friends.Olivia = {
    firstName: 'Olivia',
    lastName: 'Mikhael',
    number: '(123) 345-0000',
    address: ['150 Country Stone Street', 'Waterloo', 'ON', '4H2 N4D']
};

var list = function(friends){
    for(var key in friends){
        console.log(key);
    }
}

var search = function(name)
{
    for(var key in friends){
        var listObj = friends[key];
        if(listObj.firstName === name){
            console.log("\n" + key + 
            "\nFirst name: " + listObj.firstName,
            "\nLast Name:  " + listObj.lastName,
            "\nNumber:     " + listObj.number,
            "\nAddress:    " + listObj.address[0],
            "\n            " + listObj.address.splice(1).join(', '));
            return listObj;
        }
    }    
};

list(friends);
if(search(prompt("What is your name?", "enter your name here")) === undefined){
       console.log("name not found!");
 }

//////////////////////////////////

//printing divisables 

for (var i = 1; i < 21; i++){
    if(i % 3 === 0 && i % 5 === 0){
        console.log("FizzBuzz");
    } else if(i % 3 === 0){
         console.log("Fizz");
    } else if(i % 5 === 0){
         console.log("Buzz");
    } else {
         console.log(i);
    }
}

/////////////////////////////

//general method used by multiple objects
// here we define our method using "this", before we even introduce bob
var setAge = function (newAge) {
  this.age = newAge;
};
// now we make bob
var bob = new Object();
bob.age = 30;
bob.setAge = setAge;  
// make susan here, and first give her an age of 25
var susan = new Object();
susan.age = 25;
susan.setAge = setAge;
// here, update Susan's age to 35 using the method
susan.setAge(35);

//object associated with a method (function)
var square = new Object();
square.sideLength = 6;
square.calcPerimeter = function() {
  return this.sideLength * 4;
};
// help us define an area method here
square.calcArea = function() {
  return this.sideLength * this.sideLength;
};
var p = square.calcPerimeter();
var a = square.calcArea();

//using customized constructors by different objects
function Person(name,age) {
  this.name = name;
  this.age = age;
  this.species = "Homo Sapiens";
}
var sally = new Person("Sally Bowles", 39);
var holden = new Person("Holden Caulfield", 16);
console.log("sally's species is " + sally.species + " and she is " + sally.age);
console.log("holden's species is " + holden.species + " and he is " + holden.age);

//customized constructors with methods inside of them and how they are used
var height = prompt("enter height");
var width = prompt("enter width");

function Rectangle(height, width) {
  this.height = height;
  this.width = width;
  this.calcArea = function() {
      return this.height * this.width;
  };
  // put our perimeter function here!
  this.calcPerimeter = function(){
      return 2 * this.height + 2 * this.width;
  };
}

var rex = new Rectangle(height, width);
var area = rex.calcArea();
var perimeter = rex.calcPerimeter();

console.log("Area: " + area + "\nPerimeter: " + perimeter);

//Constructors in Review
function Rabbit(adjective) {
    this.adjective = adjective;
    this.describeMyself = function() {
        console.log("I am a " + this.adjective + " rabbit");
    };
}
// now we can easily make all of our rabbits
var rabbit1 = new Rabbit("fluffy");
var rabbit2 = new Rabbit("happy");
var rabbit3 = new Rabbit("sleepy");
rabbit1.describeMyself();
rabbit2.describeMyself();
rabbit3.describeMyself();

//better way of handling too many objects of the same kind but different info
// Our person constructor
function Person(name, age) {
    this.name = name;
    this.age = age;
}
// Now we can make an array of people
var family = new Array();
family[0] = new Person("alice", 40);
family[1] = new Person("bob", 42);
family[2] = new Person("michelle", 8);
// add the last family member, "timmy", who is 6 years old
family[3] = new Person("timmy", 6);
//print resuls
for(var i =0; i < family.length; i++){
    console.log("Hi, I am " + family[i].name 
                    + "\nI am " + family[i].age + " years old.");
}

/* 
    passing objects as parameters to functions
*/
// Our person constructor
function Person (name, age) {
    this.name = name;
    this.age = age;
}
// We can make a function which takes persons as arguments
// This one computes the difference in ages between two people
var ageDifference = function(person1, person2) {
    return person1.age - person2.age;
};
// Make a new function, olderAge, to return the age of
// the older of two people
var olderAge = function(person1, person2){
    var p1 = person1.age;
    var p2 = person2.age;
    if(p1 === p2 || p1 > p2){
        return p1;
    } else {
        return p2;
    }
};
// Let's bring back alice and billy to test our new function
var alice = new Person("Alice", 30);
var billy = new Person("Billy", 25);
console.log("The older person is " + olderAge(alice, billy));

/* 
    creating address book - working with associative arrays and literal notiation objects
*/
//object (person1)
var bob = {
    firstName: "Bob",
    lastName: "Jones",
    phoneNumber: "(650) 777-7777",
    email: "bob.jones@example.com"
};
//object (person2)
var mary = {
    firstName: "Mary",
    lastName: "Johnson",
    phoneNumber: "(650) 888-8888",
    email: "mary.johnson@example.com"
};
//array that contains objects
var contacts = [bob, mary];
// printPerson added here
function printPerson(person){
   console.log(person.firstName + " " + person.lastName);
}
//call function to print persons name
printPerson(contacts[0]);
printPerson(contacts[1]);
//another way of printing out persons name using a function 
function list() {
    var contactsLength = contacts.length;
    for (var i = 0; i < contactsLength; i++) {
        printPerson(contacts[i]);
    }
}
//call list function
list();
//search function that checks for last name 
function search(lastName) {
    var contactsLength = contacts.length;
    for (var i = 0; i < contactsLength; i++) {
        if(contacts[i].lastName === lastName){
            printPerson(contacts[i]);
        }
    }
}
//call search function
search(bob.lastName);
//create add function to add new person to address book
function add(firstName, lastName, phoneNumber, email) {
    contacts[contacts.length] = {
        firstName: firstName,
        lastName: lastName,
        phoneNumber: phoneNumber,
        email: email
    };
}
//pass values to add function
add("Olivia", "Mikhael", "(519) 333 - 7777", "olivia.mikhael@example.com");
//list the persons in the address book
list();

//////////////////////////////
/* literal object has an inner method, 
we can chage property of the object*/
var james = {
    job: "programmer",
    married: false,
    sayJob: function() {
        // complete this method
        console.log("Hi, I work as a " + this.job);
    }
};
// james' first job
james.sayJob();
// change james' job to "super programmer" here
james.job = "super programmer";
// james' second job
james.sayJob();

/////////////////////////////

// how to get the type of the var
// complete these definitions so that they will have
// the appropriate types
var anObj = { job: "I'm an object!" };
var aNumber = 42;
var aString = "I'm a string!";
console.log(typeof anObj); // should print "object"
console.log(typeof aNumber); // should print "number"
console.log(typeof aString); // should print "string"

/////////////////////////////

var myObj = {
    // finish myObj
    name: "olivia"
};
//hasOwnProperty checks if the object has a sepecific property
console.log( myObj.hasOwnProperty('name') ); // should print true
console.log( myObj.hasOwnProperty('nickname') ); // should print false

/////////////////////////////

var suitcase = {
    shirt: "Hawaiian"
};
if(suitcase.hasOwnProperty("shorts") === true){
    console.log(suitcase.shorts);
} else {
    suitcase.shorts = "blue";
    console.log(suitcase.shorts);
}

//////////////////////////////

var nyc = {
    fullName: "New York City",
    mayor: "Bill de Blasio",
    population: 8000000,
    boroughs: 5
};
//list all properties
for(var property in nyc){
    console.log(property);
}
// write a for-in loop to print the value of nyc's properties
for(var property in nyc){
    console.log(nyc[property]);
}

////////////////////////////////////
/*class that handles cats, enter cats, and teach them to meow*/
function Cat(name, breed) {
    this.name = name;
    this.breed = breed;
}
// let's make some cats!
var cheshire = new Cat("Cheshire Cat", "British Shorthair");
var gary = new Cat("Gary", "Domestic Shorthair");
// add a method "meow" to the Cat class that will allow
// all cats to print "Meow!" to the console
Cat.prototype.meow = function(){
    console.log("Meow!");
}
// add code here to make the cats meow!
var cats = [cheshire, gary];
for(var i = 0; i < cats.length; i++){
    cats[i].meow();
}

//////////////////////////////////

/*
    practice prototype and inheriting functions 
    sayName prototype method of Animal
    pengiun inherited sayName
*/
// the original Animal class and sayName method
function Animal(name, numLegs) {
    this.name = name;
    this.numLegs = numLegs;
}
//prototype method of Animal
Animal.prototype.sayName = function() {
    console.log("Hi my name is " + this.name);
};
// define a Penguin class
function Penguin(name){
    this.name = name;
    this.numLegs = 2;
}
// set Pengiun prototype to be a new instance of Animal
Penguin.prototype = new Animal();
//object passing pengiun
var penguin = new Penguin("penguin");
var penie = new Penguin("penie");
//set array for the different object and print message using the inhireted method sayName
var penguins = [penguin, penie];
for(var i = 0; i < penguins.length; i++){
    penguins[i].sayName();
}

/////////////////////////////////////

/*
    practice prototype and inherting properties 
    Emperor prototype method of Penguin
    emperor uses numLegs which is a property inherited from Penguin
*/

// Animal classes
function Animal(name, numLegs) {
    this.name = name;
    this.numLegs = numLegs;
    this.isAlive = true;
}
//Penguin inherated class from Animal
function Penguin(name) {
    this.name = name;
    this.numLegs = 2;
}
//Emperor inherated class from Penguin
function Emperor(name) {
    this.name = name;
    this.saying = "Waddle waddle";
}
// set up the prototype chain
Penguin.prototype = new Animal();
Emperor.prototype = new Penguin();
//pass naw to Emperor class
var myEmperor = new Emperor("Jules");
//printing values
console.log(myEmperor.saying); // should print "Waddle waddle"
console.log(myEmperor.numLegs); // should print 2
console.log(myEmperor.isAlive); // should print true

/////////////////////////////

/*
     Create private property 
     accessed by having a puplic method within class that returns it
     print private property outside of class
*/
function Person(first,last,age) {
   this.firstname = first;
   this.lastname = last;
   this.age = age;
   var bankBalance = 7500;
  //function to return bankBalance (private property)
   this.getBalance = function() {
      // your code should return the bankBalance
      return bankBalance;
   };
}
//setting values for john 
var john = new Person('John','Smith',30);
//failed at printing a private property
console.log(john.bankBalance);
// create a new variable myBalance that calls getBalance()
var myBalance = john.getBalance();
//print the private property
console.log(myBalance);

////////////////////////////////////

/*
    accessing private infor using password
*/
function Person(first,last,age) {
   this.firstname = first;
   this.lastname = last;
   this.age = age;
   var bankBalance = 7500;
   // public function yet accessed through pass
   this.askTeller = function(pass) {
     if (pass == 1234) {
        return bankBalance;
     } else {
        return "Wrong password.";
     }
   };
}
var john = new Person('John','Smith',30);
/* the variable myBalance should access askTeller()
   with a password as an argument  */
var myBalance = john.askTeller(1234);
console.log(myBalance);

////////////////////////////////////////

// print only the string within an object
var languages = {
    english: "Hello!",
    french: "Bonjour!",
    notALanguage: 4,
    spanish: "Hola!"
};
// print hello in the 3 different languages
for(var language in languages){
    var lang = languages[language];
    if(typeof lang === "string"){
        console.log(lang);
    }
}

////////////////////////////////////////

//class Dog
function Dog (breed) {
    this.breed = breed;
};
// add the sayHello method to the Dog class 
// so all dogs now can say hello
Dog.prototype.sayHello = function(){
    console.log("Hello this is a " + this.breed + " dog");
}
//object yourDog and print its value 
//by calling method sayHello
var yourDog = new Dog("golden retriever");
yourDog.sayHello();
//object myDog and print its value 
//by calling method sayHello
var myDog = new Dog("dachshund");
myDog.sayHello();

////////////////////////////////////////

/*
    every JavaScript object has some baggage associated with it
    Part of this baggage was the hasOwnProperty method available to all objects
    Object.prototype itself is an object
    hasOwnProperty is a boolean checks for true/false
*/
// what is this "Object.prototype" anyway...? an object!
var prototypeType = typeof Object.prototype;
console.log(prototypeType);

// now let's examine it! its a boolean
var hasOwn = Object.prototype.hasOwnProperty("hasOwnProperty");
console.log(hasOwn);

////////////////////////////////////////

//object resgister with function called add
//add calculates the total of cost
var cashRegister = {
    total:0,
    add: function(itemCost){
        this.total += itemCost;
    }
};
//call the add method for our items
var itemCost = [0.98, 1.23, 4.99, 0.45];
//add each item to the add function
for(var i = 0; i < itemCost.length; i++){
    cashRegister.add(itemCost[i]);
}
//Show the total bill
console.log('Your bill is ' + cashRegister.total);

////////////////////////////////////////////////////

/*
    cash register
    includes employee discount
    calculates total
*/

function StaffMember(name, discountPercent){
    this.name = name;
    this.discountPercent = discountPercent;
}

var sally = new StaffMember("Sally",5);
var bob = new StaffMember("Bob",10);

// Create yourself again as 'me' with a staff discount of 20%
var me = new StaffMember("Olivia",20);

var cashRegister = {
    total: 0,
    lastTransactionAmount: 0,
    add: function(itemCost){
        this.total += (itemCost || 0);
        this.lastTransactionAmount = itemCost;
    },
    scan: function(item,quantity){
        switch (item){
        case "eggs": this.add(0.98 * quantity); break;
        case "milk": this.add(1.23 * quantity); break;
        case "magazine": this.add(4.99 * quantity); break;
        case "chocolate": this.add(0.45 * quantity); break;
        }
        return true;
    },
    //take away last transaction
    voidLastTransaction: function(){
        this.total -= this.lastTransactionAmount;
        this.lastTransactionAmount = 0;
    },
    // Create a new method applyStaffDiscount here
    applyStaffDiscount: function(employee){
        this.total -= this.total * (employee.discountPercent / 100);
    }
    
};

cashRegister.scan('eggs',1);
cashRegister.scan('milk',1);
cashRegister.scan('magazine',3);
// Apply your staff discount by passing the 'me' object 
// to applyStaffDiscount
cashRegister.applyStaffDiscount(me);

// Show the total bill
console.log('Your bill is ' + cashRegister.total.toFixed(2));


