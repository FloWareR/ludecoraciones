<section>
    <div class = "container">
        <form action="<?= URL.'/savecontacts'?>"method="post">
            <div class="item-form">
                <label for="" class= "label-contact">Nombre</label>
                <input name= "name" id="name" type="text" class= "form-control"></div>
                <div class="item-form">
                <label for="" class= "label-contact">Email</label>
                <input name= "email" id="email" type="text" class= "form-control"></div>
                <div class="item-form">
                <label for="" class= "label-contact">Comentarios</label>
                <textarea name="message" id="message"></textarea></div>
            </div>  
            <div class= "item-form">
                <button type = "submit">Enviar</button>
            </div>  
        </form>
    </div>
</section>