CREATE OR REPLACE FORCE VIEW V_SSC_PARAM_PRIME_INSTALLATION
(
    ID,
    DATE_DEBUT,
    DATE_FIN,
    MONTANT
)
AS
    SELECT SSC_FPPARMEURO.NSEQ1                            AS ID,
           TO_DATE (SSC_FPPARMEURO.MINI21, 'YYYYMMDD')     AS DATE_DEBUT,
           TO_DATE (SSC_FPPARMEURO.MAXI21, 'YYYYMMDD')     AS DATE_FIN,
           (SSC_FPPARMEURO.MINI31 / 100)                   AS MONTANT
      FROM SSC_FPPARMEURO
     WHERE SSC_FPPARMEURO.NTABL1 = 576;