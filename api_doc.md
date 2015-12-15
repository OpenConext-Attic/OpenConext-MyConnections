## /api/connections ##

### `POST` /api/connections ###

_Creates a connection record from the submitted JSON data._

Creates a connection record from the submitted JSON data.

#### Parameters ####

connection:

  * type: object (ConnectionType)
  * required: true

connection[uid]:

  * type: string
  * required: true

connection[service]:

  * type: string
  * required: true

connection[cuid]:

  * type: string
  * required: true


## /api/connections/{uid} ##

### `GET` /api/connections/{uid} ###

_Retrieve Connections from database by uid (userID)._

Retrieve Connections from database by uid (userID).

#### Requirements ####

**uid**

  - Type: string
  - Description: UserID


## /api/connections/{uid}/services/{service} ##

### `DELETE` /api/connections/{uid}/services/{service} ###

_Delete connection from the database._

Delete connection from the database.

#### Requirements ####

**uid**

  - Type: string
  - Description: UserID
**service**

  - Type: string
  - Description: service machine_name
