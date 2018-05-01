       

<footer id="footer" >


    <div class="container">
        <hr />

        <div class="col-4">                
            <h3 class="title">About us</h3>
            <ul class="list-unstyled">
                <li>
                    <a href="#">About Us</a>
                </li>                                   
                <li>
                    <a href="#">Contact us</a>
                </li>
            </ul>
        </div>

        <div class="col-4">                
            <h3 class="title">Products</h3>
            <ul>                                                                       
                <li>
                    <a href="#">Fresh  Coffee</a>
                </li>
                <li>
                    <a href="#">Wholesale</a>
                </li>                                    
            </ul>
        </div>

        <div class="col-4">                
            <h3 class="title">Support</h3>
            <ul>                                    
                <li>
                    <a href="#">Terms of services</a>
                </li>
                <li>
                    <a href="#">Privacy</a>
                </li>
            </ul>
        </div>

    </div>



    <div class="container center">
        <hr />

        <div class="col-12">
            
        </div>
    </div>


    <div class="container">
        <hr />

        <div class="col-12">
            <small class="copyright"> Copyright @ 2017  Ltd.</small>
            <span><small>Site by iKissa</small></span>
        </div>
    </div>


</footer>





<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>    	

<script type="text/javascript">

    $(document).ready(function () {

        

        var tracker = "hidden"; // default
        var menu_icon = document.getElementById('menu-icon');
        var mbMenuCont = document.getElementById('mb-menu-container');

        menu_icon.onclick = function () {
            if (tracker == "hidden") {
                mbMenuCont.style.display = "block";
                tracker = "showing";
            } else if (tracker == "showing") {
                mbMenuCont.style.display = "none";
                tracker = "hidden";
            }
        };

        
    });

</script>


</body>
</html>
