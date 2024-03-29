\set ON_ERROR_STOP
\set ECHO all
BEGIN;


CREATE TABLE "public"."Assignments"( 
	"Id" int NOT NULL,
	"IdSocialWorker" int NOT NULL,
	"IdBeneficiaryCitizen" int NOT NULL,
	"StartDate" timestamp(7) NOT NULL,
	"EndDate" timestamp(7));

CREATE TABLE "public"."BeneficiaryCitizens"( 
	"Id" int NOT NULL,
	"DossierNumber" varchar NOT NULL,
	"NationalRegisterNumber" varchar NOT NULL,
	"FirstName" varchar NOT NULL,
	"LastName" varchar NOT NULL,
	"Sex" varchar NOT NULL,
	"Gsm" varchar);

CREATE TABLE "public"."SocialWorkers"( 
	"Id" int NOT NULL,
	"FirstName" varchar NOT NULL,
	"LastName" varchar NOT NULL,
	"Sex" varchar NOT NULL,
	"SamAccountName" varchar,
	"StartDate" timestamp(7) NOT NULL,
	"EndDate" timestamp(7),
	"TeamId" int NOT NULL);

CREATE TABLE "public"."Teams"( 
	"Id" int NOT NULL,
	"StartName" varchar NOT NULL,
	"Name" varchar NOT NULL);

CREATE TABLE "public"."__EFMigrationsHistory"( 
	"MigrationId" varchar(150) NOT NULL,
	"ProductVersion" varchar(32) NOT NULL);

COMMIT;
