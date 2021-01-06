# User Role Hierarchy

This project has been designed to solve the problem of determining the subordinates of a user. Given a user ID and a Role Hierarchy, we can find the list of users whose role sits under our given user.

## Requirements
- Docker
- make

## Build
Run the below command to build the application. This is required before being able to run.
```
make build
```

More dummy text

This will build a both the main container for the command to run in, as well as a test container.

## Usage
Simply run the below command to get a list of Subordinates for a user <USER_ID>
```
make getSubordinates USER_ID=1
```

You can also get the details for a specific user with the getUser command
```
make getUser USER_ID=1
```

## Testing
Run the below command to run the test suite with coverage. Coverage is generated as HTML and will be placed into a folder called `build/`
```
make test
```

## Test Header

This is dummy text