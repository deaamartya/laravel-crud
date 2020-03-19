    function getTotal(){
      console.log("masuk getTotal");
      var totals = document.getElementsByClassName("total");

      var i;
      var total_p = 0;
      for (i = 0; i < totals.length; ++i) {
        total_p = total_p + Number(totals[i].value);
      }
      document.getElementById('subtotal').value = total_p;
      document.getElementById('subtotal-val').innerHTML = money(total_p);

      var discounts = document.getElementsByClassName("discount");

      var i;
      var total_disc = 0;
      for (i = 0; i < discounts.length; ++i) {
        total_disc = total_disc + Number(discounts[i].value);
      }

      document.getElementById('total_discount').value = total_disc;
      document.getElementById('total_discount-val').innerHTML = money(total_disc);
      document.getElementById('total_payment-val').innerHTML = money(total_p-total_disc);
      document.getElementById('total_payment').value = total_p-total_disc;
    };

    function percentDisc(id){
      console.log("masuk percentDisc");
      var percent = document.getElementById("percent"+id).value;
      var total = document.getElementById("total"+id).value;
      var hasil = (Number(percent)/100) * total;
      document.getElementById("discount"+id).value = hasil;

      document.getElementById("total"+id).value = total;
      document.getElementById("total-val"+id).innerHTML = money(total-hasil);
      getTotal();
    };

    function recount(id) {
      console.log("masuk recount");
      var jumlah = document.getElementById("jumlah"+id).value;
      var price = document.getElementById("price"+id).value;
      var subtotal = (jumlah*price);
      document.getElementById("discount"+id).setAttribute("max", subtotal);
      document.getElementById("total"+id).value = subtotal;
      percentDisc(id);
    };
