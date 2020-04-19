    function inc(id){
      var value = parseInt($("#jumlah"+id).val());
      if (value < $("#jumlah"+id).attr("max")) {
          value++;
          $("#jumlah"+id).val(value);
          recount(id);
      }
    }

    function dec(id){
      var value = parseInt($("#jumlah"+id).val());
      if (value > 1) {
          value--;
          $("#jumlah"+id).val(value);
      }
      recount(id);
    }

    function getDisc($id){
        
        var disc = $("#discount"+id).val();
        var total = $("#total"+id).val();
        console.log(disc);
        console.log(total);
        return parseInt((Number(total-disc)/Number(total))*100);
    }

    function getTotal(){
      console.log("masuk getTotal");
      var jumlahs = document.getElementsByClassName("quantity");
      var prices = document.getElementsByClassName("selling_price");
      
      var i;
      var subtotal = 0;
      var items = 0;
      for (i = 0; i < jumlahs.length; ++i) {
        subtotal = subtotal + parseInt(jumlahs[i].value * prices[i].value);
        items = items + parseInt(jumlahs[i].value);
        console.log("subtotal "+subtotal);
        console.log("items "+items);
      }

      $("#items").html('<i class="material-icons mr-2" style="vertical-align: bottom;">shopping_basket</i>'+items+" item");

      $('#subtotal').val(subtotal);
      $('#subtotal-val').html(money(subtotal));

      var pajak = parseInt(subtotal*10/100);

      document.getElementById('total_tax').value = pajak;
      document.getElementById('total_tax-val').innerHTML = money(pajak);

      var discounts = document.getElementsByClassName("discount");

      var i;
      var total_disc = 0;
      for (i = 0; i < discounts.length; ++i) {
        total_disc = total_disc + parseInt(discounts[i].value);
        console.log("total_disc = "+total_disc);
      }


      document.getElementById('total_discount').value = total_disc;
      document.getElementById('total_discount-val').innerHTML = money(total_disc);
      document.getElementById('total_payment-val').innerHTML = money(subtotal-total_disc+pajak);
      document.getElementById('total_payment').value = subtotal-total_disc+pajak;
    };

    function percentDisc(id){
      console.log("masuk percentDisc");
      var percent = document.getElementById("percent"+id).value;
      var total = document.getElementById("total"+id).value;
      var hasil = parseInt(percent/100*total);
      document.getElementById("discount"+id).value = hasil;

      document.getElementById("total"+id).value = total-hasil;
      document.getElementById("total-val"+id).innerHTML = money(total-hasil);
      getTotal();
    };

    function recount(id) {
      console.log("masuk recount");
      var percent = parseInt($("#percent"+id).val());
      var jumlah = parseInt($("#jumlah"+id).val());
      var max = parseInt($("#jumlah"+id).attr('max'));
      if((percent > 100) || (percent < 0)){
        $("#percent"+id).val("0");
        $("#errpercent"+id).show();
      }
      else if((jumlah > max) || (jumlah < 1)){
        $("#jumlah"+id).val("1");
      }
      else{
        $("#errpercent"+id).hide();
        $("#percent"+id).val(parseInt($("#percent"+id).val()));
        var jumlah = document.getElementById("jumlah"+id).value;
        var price = document.getElementById("price"+id).value;
        var subtotal = (jumlah*price);
        document.getElementById("total"+id).value = subtotal;
        percentDisc(id);
      }
    };
