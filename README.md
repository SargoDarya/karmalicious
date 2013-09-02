# Karmalicious
## The Karma of IRC

Karmalicious is an attempt to introduce karma into IRC channels and give users
the reputation they deserve. It comes with various statistics and should work
as a drop in solution for eggdrop.

Karmalicious consists of 2 parts. The eggdrop module which listens to channel
messages and gives "valuable" output to the users and the PHP frontend which
shows all interesting statistics about channels and more.

### Requirements

To use Karmalicious you basically need the following things.

##### MySQL

The standard configuration for MySQL is karmalicious:karmalicious@localhost. If you
want to connect to a different server be sure to change the variables in the backend
as well as the frontend. Don't forget to import the backend/db.sql.

##### Backend (Eggdrop Module)

A running and configured eggdrop and mysqltcl as well as MySQL to store all data.
Just copy the karma.tcl module into eggdrop and setup the variables as you need them.

##### Frontend (PHP)

The really easy karmalicious frontend runs on a simple PHP server.

#### License

    DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                  Version 2, December 2004

    Copyright (C) 2013 Sargo Darya <info@sargodarya.de>

    Everyone is permitted to copy and distribute verbatim or modified
    copies of this license document, and changing it is allowed as long
    as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
    TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

    0. You just DO WHAT THE FUCK YOU WANT TO.