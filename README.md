# Battleship
A simple implementation of the battleship game in php cli

## Setup
Create a battleship folder
``` shell
mkdir battleship
```
## Start the game
Go to the root of the project
``` shell
cd battleship
```
Launch and set x and y to be the number of rows and columns of the board, example 
``` shell
php battleship.php 4 4
```
The prompt will then ask player 1 to set up his ships.

## Commands
To set up a player's ships, set x and y to be the ship's coordinates
``` shell
add [x, y]
```
When setting ships, to remove the placement
``` shell
remove [x, y]
```
To display the actual player's board with ships
``` shell
display
```
To launch an attack
``` shell
attack [x, y]
```
