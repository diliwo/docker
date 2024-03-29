update SSC_Tiers tiers
Set ID_WGH = (
    Select NumDos.ID_WGH 
    from SSC_NUMERO_DOSSIER_SOCIAL NumDos 
    where NumDos.ID_Tiers = Tiers.ID_Tiers 
        and NumDos.ID_WGH>0)  
where Tiers.ID_WGH=0