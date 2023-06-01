<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Search
{
    public function index()
    {
        return new Response(
            '
            <form>
                <label for="Article">Article:</label>
                <input type="text" id="Article" name="Article">
                <input type="button" value="Search" id="Search_button" /><br><br>
            </form>
            <p><p>
            <script>
                const api_key = document.getElementById("Article");
                const button = document.getElementById("Search_button");
                const result_text = document.querySelector("p");
                const search_values = "[ ";

                button.addEventListener("click", updateButton);

                function updateButton() {
                    $.ajax({
                        type: "GET",
                        url: "/api/StockByArticle",
                        data: {"Article": api_key.value } // data - Входные данные
                        headers: { "Authorization": "Bearer " }
                    }).done(function (data) {                // data - Выходные данные
                        data = JSON.stringify(data, null, "\t");

                        for (var d in data) {                                   
                            for (var w in d.warehouse_offers) {
                                search_values += "[ \" brand \" : " + d.brand + ";\n";
                                search_values += " \" article \" : " + d.article + ";\n";
                                search_values += " \" name \" : " + w.name + ";\n";
                                search_values += " \" quantity \" : " + w.quantity + ";\n";
                                search_values += " \" price \" : " + w.price + ";\n";
                                search_values += " \" delivery_duration \" : " + w.delivery_period + ";\n";
                                search_values += " \" vendorld \" : " + w.id + ";\n";
                                search_values += " \" warehouseAlias \" : " + w.warehouse_code + " ]; \n";
                            }
                                                       
                        }

                        search_values += " ] ";
                        result_text.innerText = search_values;
                        
                    }).fail(showError);
                    
                }
            </script>
              
            '
            
        );
    }
}
?> 