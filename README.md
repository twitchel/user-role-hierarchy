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

This will @todo

## Usage
Simply run the below command to get a list of Subordinates for a user <USER_ID>
```
make run getSubordinates <USER_ID>
```

## Testing
Run the below command to run the test suite
```
make test
```