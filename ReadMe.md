# API

Cars CRUD API

## Installation

In order for the system to run, follow this steps:

1. Run composer update

2. Create .env file and add this values

```bash
DBTYPE = pgsql;
HOST = ;
DB = ;
USER = ;
PASSWORD = ;
PORT = 5432;
```

## Usage

Read All Records Endpoint

```bash
GET https://<url>/car
```

Read Single Record Endpoint

```bash
GET https://<url>/car?id=<record-id>
```

Create a Record Endpoint

```bash
POST https://<url>/car

Form Data:
model_name
model_type
model_brand
model_year
```

Update a Record Endpoint

```bash
PUT https://<url>/car

Form Data:
id
model_name
model_type
model_brand
model_year
```

Delete a Record Endpoint

```bash
DELETE https://<url>/car?id=<record-id>

Form Data:
id
```
