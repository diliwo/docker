ALTER TABLE "public"."socialworkers" RENAME "id" TO "Id";
ALTER TABLE "public"."socialworkers" RENAME "firstname" TO "FirstName";
ALTER TABLE "public"."socialworkers" RENAME lastname TO "LastName";
ALTER TABLE "public"."socialworkers" RENAME sex TO "Sex";
ALTER TABLE "public"."socialworkers" RENAME samaccountname TO "SamAccountName";
ALTER TABLE "public"."socialworkers" RENAME startdate TO "StartDate";
ALTER TABLE "public"."socialworkers" RENAME enddate TO "EndDate";
ALTER TABLE "public"."socialworkers" RENAME teamid TO "TeamId";

ALTER TABLE "public"."beneficiarycitizens" RENAME id TO "Id";
ALTER TABLE "public"."beneficiarycitizens" RENAME dossiernumber TO "DossierNumber";
ALTER TABLE "public"."beneficiarycitizens" RENAME nationalregisternumber TO "NationalRegisterNumber";
ALTER TABLE "public"."beneficiarycitizens" RENAME firstname TO "FirstName";
ALTER TABLE "public"."beneficiarycitizens" RENAME lastname TO "LastName";
ALTER TABLE "public"."beneficiarycitizens" RENAME sex TO "Sex";
ALTER TABLE "public"."beneficiarycitizens" RENAME gsm TO "Gsm";

ALTER TABLE "public"."teams" RENAME id TO "Id";
ALTER TABLE "public"."teams" RENAME startname TO "StartName";

ALTER TABLE "public"."__efmigrationshistory" RENAME migrationId TO "MigrationId";
ALTER TABLE "public"."__efmigrationshistory" RENAME productVersion TO "ProductVersion";

ALTER TABLE "public"."assignments" RENAME id TO "Id";
ALTER TABLE "public"."assignments" RENAME idsocialworker TO "IdSocialWorker";
ALTER TABLE "public"."assignments" RENAME idbeneficiarycitizen TO "IdBeneficiaryCitizen";
ALTER TABLE "public"."assignments" RENAME startdate TO "StartDate";
ALTER TABLE "public"."assignments" RENAME enddate TO "EndDate";

ALTER TABLE "public"."assignments" RENAME TO "Assignments";
ALTER TABLE "public"."beneficiarycitizens" RENAME TO "BeneficiaryCitizens";
ALTER TABLE "public"."socialworkers" RENAME TO "SocialWorkers";
ALTER TABLE "public"."teams" RENAME TO "Teams";
ALTER TABLE "public"."__efmigrationsHistory" RENAME TO "__EFMigrationsHistory";

COMMIT;

;

Id, StartName, "Name

ALTER TABLE "public"."socialworkers" RENAME id TO "Id";
ALTER TABLE "public"."socialworkers" RENAME firstname TO "FirstName";
ALTER TABLE "public"."socialworkers" RENAME lastname TO "LastNam"e;
ALTER TABLE "public"."socialworkers" RENAME sex TO "Sex";
ALTER TABLE "public"."socialworkers" RENAME samaccountname TO SamAccountName;
ALTER TABLE "public"."socialworkers" RENAME startdate TO StartDate;
ALTER TABLE "public"."socialworkers" RENAME enddate TO EndDate;
ALTER TABLE "public"."socialworkers" RENAME teamid TO TeamId;

ALTER TABLE "public"."beneficiarycitizens" RENAME id TO Id;
ALTER TABLE "public"."beneficiarycitizens" RENAME dossiernumber TO DossierNumber;
ALTER TABLE "public"."beneficiarycitizens" RENAME nationalregisternumber TO NationalRegisterNumber;
ALTER TABLE "public"."beneficiarycitizens" RENAME firstname TO FirstName;
ALTER TABLE "public"."beneficiarycitizens" RENAME lastname TO LastName;
ALTER TABLE "public"."beneficiarycitizens" RENAME sex TO Sex;
ALTER TABLE "public"."beneficiarycitizens" RENAME gsm TO Gsm;

ALTER TABLE "public"."teams" RENAME id TO Id;
ALTER TABLE "public"."teams" RENAME startname TO StartName;

ALTER TABLE "public"."__efmigrationshistory" RENAME migrationid TO MigrationId;
ALTER TABLE "public"."__efmigrationshistory" RENAME productversion TO ProductVersion;

ALTER TABLE "public"."assignments" RENAME id TO Id;
ALTER TABLE "public"."assignments" RENAME idsocialworker TO IdSocialWorker;
ALTER TABLE "public"."assignments" RENAME idbeneficiarycitizen TO IdBeneficiaryCitizen;
ALTER TABLE "public"."assignments" RENAME startdate TO StartDate;
ALTER TABLE "public"."assignments" RENAME enddate TO EndDate;

ALTER TABLE "public"."assignments" RENAME TO "public"."Assignments";
ALTER TABLE "public"."beneficiarycitizens" RENAME TO "public"."BeneficiaryCitizens";
ALTER TABLE "public"."socialworkers" RENAME TO "public"."SocialWorkers";
ALTER TABLE "public"."teams" RENAME TO "public"."Teams";
ALTER TABLE "public"."__efmigrationsHistory" RENAME TO "public"."__EFMigrationsHistory";

COMMIT;