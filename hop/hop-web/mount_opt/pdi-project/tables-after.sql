\set ON_ERROR_STOP
\set ECHO all
BEGIN;
\set ECHO all
CREATE SEQUENCE "public"."assignments_id_seq" INCREMENT BY 1 START WITH 1 OWNED BY "public"."Assignments"."Id";
CREATE SEQUENCE "public"."beneficiarycitizens_id_seq" INCREMENT BY 1 START WITH 1 OWNED BY "public"."BeneficiaryCitizens"."Id";
CREATE SEQUENCE "public"."socialworkers_id_seq" INCREMENT BY 1 START WITH 1 OWNED BY "public"."SocialWorkers"."Id";
CREATE SEQUENCE "public"."teams_id_seq" INCREMENT BY 1 START WITH 1 OWNED BY "public"."Teams"."Id";
ALTER TABLE "public"."Assignments" ADD CONSTRAINT "PK_Assignments" PRIMARY KEY ("Id");
ALTER TABLE "public"."BeneficiaryCitizens" ADD CONSTRAINT "PK_BeneficiaryCitizens" PRIMARY KEY ("Id");
ALTER TABLE "public"."SocialWorkers" ADD CONSTRAINT "PK_SocialWorkers" PRIMARY KEY ("Id");
ALTER TABLE "public"."Teams" ADD CONSTRAINT "PK_Teams" PRIMARY KEY ("Id");
ALTER TABLE "public"."__EFMigrationsHistory" ADD CONSTRAINT "PK___EFMigrationsHistory" PRIMARY KEY ("MigrationId");
ALTER TABLE "public"."Assignments" ADD CONSTRAINT "FK_Assignments_BeneficiaryCitizens_IdBeneficiaryCitizen" FOREIGN KEY ("IdBeneficiaryCitizen") REFERENCES "public"."BeneficiaryCitizens" ( "Id") ON DELETE CASCADE;
ALTER TABLE "public"."Assignments" ADD CONSTRAINT "FK_Assignments_SocialWorkers_IdSocialWorker" FOREIGN KEY ("IdSocialWorker") REFERENCES "public"."SocialWorkers" ( "Id") ON DELETE CASCADE;
ALTER TABLE "public"."SocialWorkers" ADD CONSTRAINT "FK_SocialWorkers_Teams_TeamId" FOREIGN KEY ("TeamId") REFERENCES "public"."Teams" ( "Id") ON DELETE CASCADE;
ALTER TABLE "public"."Assignments" ALTER COLUMN "Id" SET DEFAULT nextval('"public"."assignments_id_seq"');
ALTER TABLE "public"."BeneficiaryCitizens" ALTER COLUMN "Id" SET DEFAULT nextval('"public"."beneficiarycitizens_id_seq"');
ALTER TABLE "public"."SocialWorkers" ALTER COLUMN "Id" SET DEFAULT nextval('"public"."socialworkers_id_seq"');
ALTER TABLE "public"."Teams" ALTER COLUMN "Id" SET DEFAULT nextval('"public"."teams_id_seq"');
COMMIT;
