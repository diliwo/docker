<script>
    $("#listTables").change(function () {
    
        
    
        $.ajax(
        {	
            type: "POST",
            url: "../controler/get_table_by_id.php",
            dataType : "html",
            data: { id_table: $('#listTables option:selected').val()},
            
            error:function(msg, string){
                
                alert(JSON.stringify(msg, null, 2));
                alert(JSON.stringify(string, null, 2));	
            },
            success:function(data){
                
                $("#contenu_tableau").empty().hide();
                $("#contenu_tableau").append(data);
                $("#contenu_tableau").fadeIn(0);             
            }	
        });                       
            
    });
    $("#recordForm").submit(function( event ) {
           
        if(confirm(message)){       

                $.ajax({	
                    type: "POST",
                    url: "../controler/add_record.php",
                    dataType : "html",
                    data: { 

                        ntabl1: $("#listTables").val(),
                        nseq1: $("#nseq1Input").val(),
                        mini11: $("#mini11Input").val(),
                        maxi11: $("#maxi11Input").val(),
                        mini21: $("#mini21Input").val(),
                        maxi21: $("#maxi21Input").val(),
                        mini31: $("#mini31Input").val(),
                        maxi31: $("#maxi31Input").val(),
                        mini41: $("#mini41Input").val(),
                        maxi41: $("#maxi41Input").val(),
                        mini51: $("#mini51Input").val(),
                        maxi51: $("#maxi51Input").val(),
                        mini61: $("#mini61Input").val(),
                        maxi61: $("#maxi61Input").val(),
                        mini71: $("#mini71Input").val(),
                        maxi71: $("#maxi71Input").val(),
                        mini81: $("#mini81Input").val(),
                        maxi81: $("#maxi81Input").val(),
                        mini91: $("#mini91Input").val(),
                        maxi91: $("#maxi91Input").val(),
                        amin11: $("#amin11Input").val(),
                        amax11: $("#amax11Input").val(),
                        infor1: $("#infor1Input").val()
                                                    },
                    
                    error:function(msg, string){
                        
                        alert(JSON.stringify(msg, null, 2));
                        alert(JSON.stringify(string, null, 2));	
                    },
                    success:function(data){
                        $("#recordManagement .close").click();   

                        if(data.length == 0){

                            $.ajax(
                            {	
                                type: "POST",
                                url: "../controler/get_table_by_id.php",
                                dataType : "html",
                                data: { id_table: $("#listTables").val()},
                                
                                error:function(msg, string){
                                    
                                    alert(JSON.stringify(msg, null, 2));
                                    alert(JSON.stringify(string, null, 2));	
                                },
                                success:function(data){
                                    
                                    $("#contenu_tableau").empty().hide();
                                    $("#contenu_tableau").append(data);
                                    $("#contenu_tableau").fadeIn(0);             
                                }	
                            });                                        
                        }
                        else{
                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(data);
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show');     
                        }              
                    }		                           
                });
                return;            
            }
        event.preventDefault();
    });
    $("#tableForm").submit(function( event ) {

            if(confirm("Êtes-vous sûr de vouloir ajouter cette table")){
                
                $.ajax({	
                    type: "POST",
                    url: "add_table.php",
                    dataType : "html",
                    data: {                       
                        
                        mini11: $("#mini11InputTable").val(),
                        maxi11: $("#maxi11InputTable").val(),
                        mini21: $("#mini21InputTable").val(),
                        maxi21: $("#maxi21InputTable").val(),
                        mini31: $("#mini31InputTable").val(),
                        maxi31: $("#maxi31InputTable").val(),
                        mini41: $("#mini41InputTable").val(),
                        maxi41: $("#maxi41InputTable").val(),
                        mini51: $("#mini51InputTable").val(),
                        maxi51: $("#maxi51InputTable").val(),
                        mini61: $("#mini61InputTable").val(),
                        maxi61: $("#maxi61InputTable").val(),
                        mini71: $("#mini71InputTable").val(),
                        maxi71: $("#maxi71InputTable").val(),
                        mini81: $("#mini81InputTable").val(),
                        maxi81: $("#maxi81InputTable").val(),
                        mini91: $("#mini91InputTable").val(),
                        maxi91: $("#maxi91InputTable").val(),
                        amin11: $("#amin11InputTable").val(),
                        amax11: $("#amax11InputTable").val(),
                        infor1: $("#infor1InputTable").val()
                    },
                    
                    error:function(msg, string){
                        
                        alert(JSON.stringify(msg, null, 2));
                        alert(JSON.stringify(string, null, 2));	
                    },
                    success:function(data){
                        $("#tableManagement .close").click();                             
                       
                        if(data.length != 0){

                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(data);
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show');
                        }
                        else{


                            $.ajax(
                            {	
                                type: "POST",
                                url: "../controler/get_all_tables.php",
                                dataType : "html",
                                data: { ajout: 1
                                },
                                
                                error:function(msg, string){
                                    
                                    alert(JSON.stringify(msg, null, 2));
                                    alert(JSON.stringify(string, null, 2));	
                                },
                                success:function(data){
                                    
                                    $("#listTables").empty().hide();
                                    $("#listTables").append(data);
                                    $("#listTables").fadeIn(0);             
                                }	
                            });

                            $.ajax(
                            {	
                                type: "POST",
                                url: "../controler/get_last_table.php",
                                dataType : "html",
                                                                
                                error:function(msg, string){
                                    
                                    alert(JSON.stringify(msg, null, 2));
                                    alert(JSON.stringify(string, null, 2));	
                                },
                                success:function(data){
                                    
                                    $("#contenu_tableau").empty().hide();
                                    $("#contenu_tableau").append(data);
                                    $("#contenu_tableau").fadeIn(0);             
                                }	
                            });       
                        }
                    }
                });
            }
            event.preventDefault();
    });
    $("#bDupliquer").click(function( event ){

        if(confirm("Êtes-vous sûr de vouloir dupliquer ces records?")){ 

            $("#tabDupli tr.bod").each(function() {    

               //alert($(this).find('input.nseq1').val());
               //console.log($(this).find('input.nseq1').val());
               $.when(
                $.ajax({	
                    type: "POST",
                    url: "../controler/add_record.php",
                    dataType : "html",
                    async: false,
                    data: { 
                            ntabl1: $("#listTables").val(),
                            mini11: $(this).find('input.mini11').val(),
                            maxi11: $(this).find('input.maxi11').val(),
                            mini21: $(this).find('input.mini21').val(),
                            maxi21: $(this).find('input.maxi21').val(),                           
                            mini31: $(this).find('input.mini31').val(),
                            maxi31: $(this).find('input.maxi31').val(),
                            mini41: $(this).find('input.mini41').val(),
                            maxi41: $(this).find('input.maxi41').val(),
                            mini51: $(this).find('input.mini51').val(),
                            maxi51: $(this).find('input.maxi51').val(),
                            mini61: $(this).find('input.mini61').val(),
                            maxi61: $(this).find('input.maxi61').val(),
                            mini71: $(this).find('input.mini71').val(),
                            maxi71: $(this).find('input.maxi71').val(),
                            mini81: $(this).find('input.mini81').val(),
                            maxi81: $(this).find('input.maxi81').val(),
                            mini91: $(this).find('input.mini91').val(),
                            maxi91: $(this).find('input.maxi91').val(),
                            amin11: $(this).find('input.amin11').val(),
                            amax11: $(this).find('input.amax11').val(),
                            infor1: $(this).find('input.infor1').val()
                            },
                    
                    error:function(msg, string){
                        succes = false;
                        console.log(JSON.stringify(msg, null, 2));
                        console.log(JSON.stringify(string, null, 2));	
                    },
                    success:function(data){                             
                                                
                        if(data.length != 0){
                                
                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(data);
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show'); 
                                                                    
                        }                                                                 
                    }		                           
                })).then(function(){console.log("ajax fait");});                   
            });
            $.ajax(
            {	
                type: "POST",
                url: "../controler/get_table_by_id.php",
                dataType : "html",
                async: false,
                data: { id_table: $("#listTables").val()},
                
                error:function(msg, string){
                    
                    alert(JSON.stringify(msg, null, 2));
                    alert(JSON.stringify(string, null, 2));	
                },
                success:function(data){
                    $("#dupliModal .close").click();
                    $("#contenu_tableau").empty().hide();
                    $("#contenu_tableau").append(data);
                    $("#contenu_tableau").fadeIn(0);             
                }	
            });        
        }
    });
    $("#bAjouter").click(function(){
            
            $("#action").val("add")
            $("#nseq1Input").val("");
            $("#mini11Input").val("");
            $("#maxi11Input").val("");
            $("#mini21Input").val("");
            $("#maxi21Input").val("");
            $("#mini31Input").val("");
            $("#maxi31Input").val("");
            $("#mini41Input").val("");
            $("#maxi41Input").val("");
            $("#mini51Input").val("");
            $("#maxi51Input").val("");
            $("#mini61Input").val("");
            $("#maxi61Input").val("");
            $("#mini71Input").val("");
            $("#maxi71Input").val("");
            $("#mini81Input").val("");
            $("#maxi81Input").val("");
            $("#mini91Input").val("");
            $("#maxi91Input").val("");
            $("#amin11Input").val("");
            $("#amax11Input").val("");
            $("#infor1Input").val(""); 
                     
    });
    $("#bModifier").click(function(e){

        if(confirm("Êtes-vous sûr de vouloir modifier ces records?")){ 

            $("#tabDupli tr.bod").each(function() {               
                
                $.when($.ajax({	
                    type: "POST",
                    url: "../controler/update_record.php",
                    dataType : "html",
                    async: false,
                    data: { 
                            ntabl1: $("#listTables").val(),
                            nseq1: $(this).find('input.nseq1').val(),
                            mini11: $(this).find('input.mini11').val(),
                            maxi11: $(this).find('input.maxi11').val(),
                            mini21: $(this).find('input.mini21').val(),
                            maxi21: $(this).find('input.maxi21').val(),                           
                            mini31: $(this).find('input.mini31').val(),
                            maxi31: $(this).find('input.maxi31').val(),
                            mini41: $(this).find('input.mini41').val(),
                            maxi41: $(this).find('input.maxi41').val(),
                            mini51: $(this).find('input.mini51').val(),
                            maxi51: $(this).find('input.maxi51').val(),
                            mini61: $(this).find('input.mini61').val(),
                            maxi61: $(this).find('input.maxi61').val(),
                            mini71: $(this).find('input.mini71').val(),
                            maxi71: $(this).find('input.maxi71').val(),
                            mini81: $(this).find('input.mini81').val(),
                            maxi81: $(this).find('input.maxi81').val(),
                            mini91: $(this).find('input.mini91').val(),
                            maxi91: $(this).find('input.maxi91').val(),
                            amin11: $(this).find('input.amin11').val(),
                            amax11: $(this).find('input.amax11').val(),
                            infor1: $(this).find('input.infor1').val()
                            },
                    
                    error:function(msg, string){
                       
                        console.log(JSON.stringify(msg, null, 2));
                        console.log(JSON.stringify(string, null, 2));	
                    },
                    success:function(data){                             
                                                
                        if(data.length != 0){
                                
                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(data);
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show'); 
                                                                    
                        }                                                                 
                    }		                           
              })).then(function(){console.log("ajax fait");});          
            });
            $.ajax({	
                type: "POST",
                url: "../controler/get_table_by_id.php",
                dataType : "html",
                async: false,
                data: { id_table: $("#listTables").val()},
                
                error:function(msg, string){
                    
                    alert(JSON.stringify(msg, null, 2));
                    alert(JSON.stringify(string, null, 2));	
                },
                success:function(data){
                    $("#dupliModal .close").click();
                    $("#contenu_tableau").empty().hide();
                    $("#contenu_tableau").append(data);
                    $("#contenu_tableau").fadeIn(0);             
                }	
            });    
        }
      
       /* if(confirm("Êtes-vous sûr de vouloir dupliquer ces records?")){ 

            var succes = true;

            $("#tabDupli tr.bod").each(function() {               
               
                $.ajax({	
                    type: "POST",
                    url: "../controler/update_recard.php",
                    dataType : "html",
                    data: { 
                            ntabl1: $("#listTables").val(),
                            mini11: $(this).find('input.mini11').val(),
                            maxi11: $(this).find('input.maxi11').val(),
                            mini21: $(this).find('input.mini21').val(),
                            maxi21: $(this).find('input.maxi21').val(),                           
                            mini31: $(this).find('input.mini31').val(),
                            maxi31: $(this).find('input.maxi31').val(),
                            mini41: $(this).find('input.mini41').val(),
                            maxi41: $(this).find('input.maxi41').val(),
                            mini51: $(this).find('input.mini51').val(),
                            maxi51: $(this).find('input.maxi51').val(),
                            mini61: $(this).find('input.mini61').val(),
                            maxi61: $(this).find('input.maxi61').val(),
                            mini71: $(this).find('input.mini71').val(),
                            maxi71: $(this).find('input.maxi71').val(),
                            mini81: $(this).find('input.mini81').val(),
                            maxi81: $(this).find('input.maxi81').val(),
                            mini91: $(this).find('input.mini91').val(),
                            maxi91: $(this).find('input.maxi91').val(),
                            amin11: $(this).find('input.amin11').val(),
                            amax11: $(this).find('input.amax11').val(),
                            infor1: $(this).find('input.infor1').val()
                            },
                    
                    error:function(msg, string){
                        succes = false;
                        console.log(JSON.stringify(msg, null, 2));
                        console.log(JSON.stringify(string, null, 2));	
                    },
                    success:function(data){                             
                                                
                        if(data.length != 0){
                                
                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(data);
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show'); 
                                                                    
                        }                                                                 
                    }		                           
                });                     
            });
            if(!succes){

                alert("erreur lors de l\'ajout d'un record dupliqué")
            }
            else{
                $.ajax(
                    {	
                        type: "POST",
                        url: "../controler/get_table_by_id.php",
                        dataType : "html",
                        data: { id_table: $("#listTables").val()},
                        
                        error:function(msg, string){
                            
                            alert(JSON.stringify(msg, null, 2));
                            alert(JSON.stringify(string, null, 2));	
                        },
                        success:function(data){
                            $("#dupliModal .close").click();
                            $("#contenu_tableau").empty().hide();
                            $("#contenu_tableau").append(data);
                            $("#contenu_tableau").fadeIn(0);             
                        }	
                    }); 
                 return;
            }           
        }
        event.preventDefault();  */

            /*var selected = $("#tab tr.selected");

            if(typeof (selected.prop('outerHTML')) != 'undefined'){
                
                $("#action").val("update");           
                $("#nseq1Input").val(selected.find('td.' + 'nseq1 ').html());
                $("#mini11Input").val(selected.find('td.' + 'mini11').html());
                $("#maxi11Input").val(selected.find('td.' + 'maxi11').html());
                $("#mini21Input").val(selected.find('td.' + 'mini21').html());
                $("#maxi21Input").val(selected.find('td.' + 'maxi21').html());
                $("#mini31Input").val(selected.find('td.' + 'mini31').html());
                $("#maxi31Input").val(selected.find('td.' + 'maxi31').html());
                $("#mini41Input").val(selected.find('td.' + 'mini41').html());
                $("#maxi41Input").val(selected.find('td.' + 'maxi41').html());
                $("#mini51Input").val(selected.find('td.' + 'mini51').html());
                $("#maxi51Input").val(selected.find('td.' + 'maxi51').html());
                $("#mini61Input").val(selected.find('td.' + 'mini61').html());
                $("#maxi61Input").val(selected.find('td.' + 'maxi61').html());
                $("#mini71Input").val(selected.find('td.' + 'mini71').html());
                $("#maxi71Input").val(selected.find('td.' + 'maxi71').html());
                $("#mini81Input").val(selected.find('td.' + 'mini81').html());
                $("#maxi81Input").val(selected.find('td.' + 'maxi81').html());
                $("#mini91Input").val(selected.find('td.' + 'mini91').html());
                $("#maxi91Input").val(selected.find('td.' + 'maxi91').html());
                $("#amin11Input").val(selected.find('td.' + 'amin11').html());
                $("#amax11Input").val(selected.find('td.' + 'amax11').html());
                $("#infor1Input").val(selected.find('td.' + 'infor1').html());
            }
            else{
                alert("Aucune ligne sélectionnée!");               
                e.stopPropagation();          
            }    
            //formulaire -> ajax*/
    });
    $("#bSupprimer").click(function(){
            
            var selected = $("#tab tr.selected");
            console.log(selected);
            if(typeof (selected.prop('outerHTML')) != 'undefined'){
                
                if(confirm("Êtes-vous sûr de vouloir supprimer ce record?")){
                    var ntabl1=$("#listTables").val();
                    var nseq1=selected.find('td.' + 'nseq1 ').html();

                    $.ajax(
                    {	
                        type: "POST",
                        url: "../controler/delete_record.php",
                        dataType : "html",
                        data: { 
                                ntabl1: $("#listTables").val(),
                                nseq1: selected.find('td.' + 'nseq1 ').html()
                        },
                        
                        error:function(msg, string){
                            
                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(JSON.stringify(msg, null, 2));
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show');     	
                        },
                        success:function(data){                            
                            if(data.length == 0){

                                
                                $.ajax(
                                {	
                                    type: "POST",
                                    url: "../controler/get_table_by_id.php",
                                    dataType : "html",
                                    data: { id_table: ntabl1},
                                    
                                    error:function(msg, string){
                                        
                                        $("#contenu-modal-alert").empty().hide();
                                        $("#contenu-modal-alert").append(JSON.stringify(msg, null, 2));
                                        $("#contenu-modal-alert").fadeIn(0);
                                        $('#alertModal').modal('show');     
                                    },
                                    success:function(data){
                                        
                                        $("#contenu_tableau").empty().hide();
                                        $("#contenu_tableau").append(data);
                                        $("#contenu_tableau").fadeIn(0);             
                                    }	
                                });                                 
                            }
                            else{

                                $("#contenu-modal-alert").empty().hide();
                                $("#contenu-modal-alert").append(data);
                                $("#contenu-modal-alert").fadeIn(0);
                                $('#alertModal').modal('show');     
                            }              
                        }	
                    });
                }
            } 
            else{

                $("#alerts").empty().hide();
                $("#alerts").append('<div class="alert alert-danger titre-centrer styleAlert" id="alertWarning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Attention</strong> Veuillez sélectionner une ligne dans le tableau.</div>');
                $("#alerts").fadeIn(0);                               
            }  
            //ajax
    });
   /* $("#bDupliquer").click(function(){

        var selected = $("#tab tr.selected");

        if(typeof (selected.prop('outerHTML')) != 'undefined'){

            if(confirm("Êtes-vous sûr de vouloir dupliquer ce record?")){

                $.ajax(
                {	
                    type: "POST",
                    url: "../controler/add_record.php",
                    dataType : "html",
                    data: { 
                            ntabl1: $("#listTables").val(),
                            mini11: selected.find('td.' + 'mini11').html(),
                            maxi11: selected.find('td.' + 'maxi11').html(),
                            mini21: selected.find('td.' + 'mini21').html(),
                            maxi21: selected.find('td.' + 'maxi21').html(),
                            mini31: selected.find('td.' + 'mini31').html(),
                            maxi31: selected.find('td.' + 'maxi31').html(),
                            mini41: selected.find('td.' + 'mini41').html(),
                            maxi41: selected.find('td.' + 'maxi41').html(),
                            mini51: selected.find('td.' + 'mini51').html(),
                            maxi51: selected.find('td.' + 'maxi51').html(),
                            mini61: selected.find('td.' + 'mini61').html(),
                            maxi61: selected.find('td.' + 'maxi61').html(),
                            mini71: selected.find('td.' + 'mini71').html(),
                            mini71: selected.find('td.' + 'mini71').html(),
                            maxi71: selected.find('td.' + 'maxi71').html(),
                            mini81: selected.find('td.' + 'mini81').html(),
                            maxi81: selected.find('td.' + 'maxi81').html(),
                            mini91: selected.find('td.' + 'mini91').html(),
                            maxi91: selected.find('td.' + 'maxi91').html(),
                            amin11: selected.find('td.' + 'amin11').html(),
                            amax11: selected.find('td.' + 'amax11').html(),
                            infor1: selected.find('td.' + 'infor1').html(),
                    },
                    
                    error:function(msg, string){
                        
                        $("#contenu-modal-alert").empty().hide();
                        $("#contenu-modal-alert").append(JSON.stringify(msg, null, 2));
                        $("#contenu-modal-alert").fadeIn(0);
                        $('#alertModal').modal('show'); 
                    },
                    success:function(data){ 
                                       
                        if(data.length == 0){                           
                        
                            $.ajax(
                            {	
                                type: "POST",
                                url: "../controler/get_table_by_id.php",
                                dataType : "html",
                                data: { id_table: $("#listTables").val()},
                                
                                error:function(msg, string){
                                    
                                    $("#contenu-modal-alert").empty().hide();
                                    $("#contenu-modal-alert").append(JSON.stringify(msg, null, 2));
                                    $("#contenu-modal-alert").fadeIn(0);
                                    $('#alertModal').modal('show'); 
                                },
                                success:function(data){
                                    
                                    $("#contenu_tableau").empty().hide();
                                    $("#contenu_tableau").append(data);
                                    $("#contenu_tableau").fadeIn(0);             
                                }	
                            });                            
                        }
                        else{

                            $("#contenu-modal-alert").empty().hide();
                            $("#contenu-modal-alert").append(data);
                            $("#contenu-modal-alert").fadeIn(0);
                            $('#alertModal').modal('show');     
                        }              
                    }	
                });
            }
        }
        else{

            $("#alerts").empty().hide();
            $("#alerts").append('<div class="alert alert-danger titre-centrer styleAlert" id="alertWarning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Attention</strong> Veuillez sélectionner une ligne dans le tableau.</div>');
            $("#alerts").fadeIn(0);                               
        }                  
    });*/
    $("#bEnvoiSelection").click(function(e){
       var html = "";

       html = html + '<table id="tabDupli" class="table-bordered table-condensed cf padding10">';
       html = html + '<thead class="cf">';
       html = html + '<tr >';
       html = html + '<th>NSEQ1</th>';
       html = html + '<th>MINI11</th>';
       html = html + '<th>MAXI11</th>';
       html = html + '<th>MINI21</th>';
       html = html + '<th>MAXI21</th>';
       html = html + '<th>MINI31</th>';
       html = html + '<th>MAXI31</th>';
       html = html + '<th>MINI41</th>';
       html = html + '<th>MAXI41</th>';
       html = html + '<th>MINI51</th>';
       html = html + '<th>MAXI51</th>';
       html = html + '<th>MINI61</th>';
       html = html + '<th>MAXI61</th>';
       html = html + '<th>MINI71</th>';
       html = html + '<th>MAXI71</th>';
       html = html + '<th>MINI81</th>';
       html = html + '<th>MAXI81</th>';
       html = html + '<th>MINI91</th>';
       html = html + '<th>MAXI91</th>';
       html = html + '<th>AMIN11</th>';
       html = html + '<th>AMAX11</th>';
       html = html + '<th>INFOR1</th>';
       html = html + '<th style="width:16px"></th>';
       html = html + '</tr>';
       html = html + '</thead>';
       html = html + '<tbody> ';    

          $("#tab tr.selected").each(function() {          
            html = html + '<tr class="bod">';
            html = html + '<td class="nseq1" ><input type="number" class="form-control input-sm cell nseq1" id="' + $(this).find('td.' + 'nseq1').html() + '" readonly value = ' + $(this).find('td.' + 'nseq1 ').html() + '></td>';
            html = html + '<td class="mini11" ><input type="number" class="form-control input-sm cell mini11" id="mini11/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini11 ').html() + '></td>';
            html = html + '<td class="maxi11" ><input type="number" class="form-control input-sm cell maxi11" id="maxi11/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi11 ').html() + '></td>';
            html = html + '<td class="mini21" ><input type="number" class="form-control input-sm cell mini21" id="mini21/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini21 ').html() + '></td>';
            html = html + '<td class="maxi21" ><input type="number" class="form-control input-sm cell maxi21" id="maxi21/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi21 ').html() + '></td>';
            html = html + '<td class="mini31" ><input type="number" class="form-control input-sm cell mini31" id="mini31/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini31 ').html() + '></td>';
            html = html + '<td class="maxi31" ><input type="number" class="form-control input-sm cell maxi31" id="maxi31/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi31 ').html() + '></td>';
            html = html + '<td class="mini41" ><input type="number" class="form-control input-sm cell mini41" id="mini41/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini41 ').html() + '></td>';
            html = html + '<td class="maxi41" ><input type="number" class="form-control input-sm cell maxi41" id="maxi41/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi41 ').html() + '></td>';
            html = html + '<td class="mini51" ><input type="number" class="form-control input-sm cell mini51" id="mini51/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini51 ').html() + '></td>';
            html = html + '<td class="maxi51" ><input type="number" class="form-control input-sm cell maxi51" id="maxi51/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi51 ').html() + '></td>';
            html = html + '<td class="mini61" ><input type="number" class="form-control input-sm cell mini61" id="mini61/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini61 ').html() + '></td>';
            html = html + '<td class="maxi61" ><input type="number" class="form-control input-sm cell maxi61" id="maxi61/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi61 ').html() + '></td>';
            html = html + '<td class="mini71" ><input type="number" class="form-control input-sm cell mini71" id="mini71/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini71 ').html() + '></td>';
            html = html + '<td class="maxi71" ><input type="number" class="form-control input-sm cell maxi71" id="maxi71/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi71 ').html() + '></td>';
            html = html + '<td class="mini81" ><input type="number" class="form-control input-sm cell mini81" id="mini81/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini81 ').html() + '></td>';
            html = html + '<td class="maxi81" ><input type="number" class="form-control input-sm cell maxi81" id="maxi81/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi81 ').html() + '></td>';
            html = html + '<td class="mini91" ><input type="number" class="form-control input-sm cell mini91" id="mini91/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'mini91 ').html() + '></td>';
            html = html + '<td class="maxi91" ><input type="number" class="form-control input-sm cell maxi91" id="maxi91/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'maxi91 ').html() + '></td>';
            html = html + '<td class="amin11" ><input type="text" class="form-control input-sm cell amin11" id="amin11/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'amin11 ').html() + '></td>';
            html = html + '<td class="amax11" ><input type="text" class="form-control input-sm cell amax11" id="amax11/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'amax11 ').html() + '></td>';
            html = html + '<td class="infor1" ><input type="text" class="form-control input-sm cell infor1" id="infor1/' + $(this).find('td.' + 'nseq1').html() + '" value = ' + $(this).find('td.' + 'infor1 ').html() + '></td>';
            html = html + '</tr>';
        }); 

      html = html + '</tbody> ';    
      html = html + '</table> ';   
      //console.log(html); 
        
        $("#contenu-modal-dupli").empty().hide();
        $("#contenu-modal-dupli").append(html);
        $("#contenu-modal-dupli").fadeIn(0);
        $('#dupliModal').modal('show');
    });
    $(".modal-wide").on("show.bs.modal", function() {
        var height = $(window).height() - 200;
        $(this).find(".modal-body").css("max-height", height);
    });

    
</script>  