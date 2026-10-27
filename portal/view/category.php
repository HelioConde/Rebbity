<?php
require_once __DIR__ . '/../../app/bootstrap.php';
rb_require_partner();
?>
<div>
    <p class="subTitle">
        Este é o seu cardápio para entregas. Aqui você define quais itens os clientes vão poder pedir pelo Rebbity e
        receber em casa.
    </p>
</div>

<div class="subMenu">
    <div class="subMenuTitle subMenuactive">
        Cardápios
    </div>
    <div class="subMenuTitle">
        Integração com PDV
    </div>
</div>

<div class="categoryMenu">
    <div>
        <button class="categoryButtonAdd" onclick="addCategory()">
            + Adicionar categoria
        </button>
    </div>
    <div class="categoryMenuText">
        Reordenar
    </div>
</div>

<div class="categoryBar">
    <div>
        <select name="category" id="category" class="select">
            <option value="all"> Todas Categorias</option>
        </select>
    </div>
    <div class="categoryWidth">
        <input type="search" class="categoryBarSearch" name="" id="">
    </div>
</div>

<div id="viewCategory">
</div>


<div id="viewMenu">
    <!-- insert Cateory -->
    <div id="menuBox" class="menuRight">
        <div class="flexTitle title">
            <div>
                Nova categoria
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div class="vh100">
            <div class="subMenuTitle">
                Selecione o modelo de categoria para dividir o seu cardápio
            </div>
            <div class="viewBox" onclick="addCategoryItens()">
                <div>
                    <span class="utensils">
                    </span>
                </div>
                <div class="viewBox2">
                    <h1 class="viewTitle">
                        Itens principais
                    </h1>
                    <div class="subTitle2">
                        Comidas, lanches, sobremesas, etc.
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>

    <div id="newCategory" class="menuRight">
        <div class="flexTitle title">
            <div>
                Nova categoria
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div class="vh100">
            <div class="subMenuTitle">
                Selecione o modelo de categoria para dividir o seu cardápio
            </div>
            <div>
                <div class="viewBox">
                    <div class="caregoryViewImage">
                        <span class="utensils">
                        </span>
                    </div>
                    <div class="viewBox3">
                        <h1 class="viewTitle">
                            Itens principais
                        </h1>
                        <div class="subTitle3">
                            Alterar
                        </div>
                    </div>
                </div>
                <div>
                    <form id="insertCategory" method="post">
                        <div class="viewInputBox">
                            <h2>
                                Nome da categoria
                            </h2>
                            <div>
                                <input type="text" id="nameCategory" class="inputView" name="nameCategory"
                                    placeholder="Exemplo: Promoção">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="newCategoryButton">
            <button class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</button>
            <button id="sendCategory" class="newCategoryButtonDisabled"
                onclick="send('insertCategory')">Salvar</button>
        </div>
    </div>

    <!-- edit name -->
    <div id="editName" class="menuRight">
        <div class="flexTitle title">
            <div>
                Editar nome da categoria
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div class="vh100">
            <div class="subMenuTitle">
                Digite um novo nome para a categoria
                <span id="categoryNameEdit"></span>
            </div>
            <div>
                <div>
                    <form id="categoryChageName" method="post">
                        <div class="viewInputBox">
                            <h2>
                                Nome da categoria
                            </h2>
                            <div>
                                <input type="text" class="inputView" id="editNameCategory" name="editNameCategory"
                                    placeholder="Exemplo: Promoção">
                                <input type="hidden" class="inputView" id="editNameCategoryID"
                                    name="editNameCategoryID">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="newCategoryButton">
            <button class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</button>
            <button id="editNameCategory2" class="newCategoryButtonDisabled"
                onclick="send('categoryChageName')">Salvar</button>
        </div>
    </div>

    <!-- Delete name -->
    <div id="delName" class="menuRight">
        <div class="flexTitle title">
            <div>
                Remover categoria
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div class="vh100">
            <div>
                <div>
                    <form id="categoryChageDel" method="post">
                        <div class="viewInputBox">
                            <h2>
                                Desejá Remover a categoria
                                <span id="categoryNameDel"></span>?
                            </h2>
                            <div>
                                <input type="hidden" class="inputView" id="delNameCategoryID" name="delNameCategoryID">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="newCategoryButton">
            <button class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</button>
            <button id="editNameCategory" class="newCategoryButtonEnabled"
                onclick="send('categoryChageDel')">Remover</button>
        </div>
    </div>

    <!-- new Item  -->
    <div id="newItem" class="menuRight">
        <div class="flexTitle title">
            <div>
                Criar Item
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div id="navItens">
            <div class="subMenu">
                <div class="subMenuTitle newItemDetails subMenuactive">
                    Detalhes
                </div>
                <div class="subMenuTitle newItemAddOs">
                    Complementos
                </div>
                <div class="subMenuTitle newItemRating">
                    Classificação
                </div>
                <div class="subMenuTitle newItemAvailability">
                    Disponibilidade
                </div>
            </div>
        </div>
        <form class="vh100" id="insertNewItem" method="post"><input type="hidden" name="newItemCategoryIdMain" id="newItemCategoryIdMain">
            <div class="details">
                <div class="subMenuTitle">
                </div>
                <div>
                    <div class="newSubCategoryBox3">
                        <div class="newItemBox">
                            <div class="newSubCategoryNamePreco">
                                <div>
                                    <label for="newItemName">Nome</label>
                                    <input class="newItemInput" type="text" placeholder="X-Tudo" name="newItemName"
                                        id="newItemName">
                                </div>
                                <div>
                                    <label for="newItemSale">Preço</label>
                                    <input class="newItemInput" type="text" name="newItemSale" id="newItemSale"
                                        placeholder="R$ 99,99">
                                </div>
                            </div>
                            <label for="newItemDescription">Descrição</label>
                            <textarea class="newItemInput" name="newItemDescription" id="newItemDescription" rows="7"
                                placeholder="Exemplo: Pão, Carne,queijo, Ovo, Bacon, Presunto, Alface, Tomate, Cheddar, Requeijão, Banana, Calabresa, Milho e Batata Palha."></textarea>
                            <label for="newItemPDV">Código PDV</label>
                            <input class="newItemInput" type="text" name="newItemPDV" id="newItemPDV">
                        </div>
                        <div class="newItemBox">
                            <p>Imagem de capa</p>
                            <h6>Aparece na listagem e no detalhe do prato</h6>
                            <div id="drop_file_zone" ondrop="upload_file2(event)" ondragover="return false">
                                <img src="" id="itemImageShow" alt="">
                                <div id="drag_upload_file">
                                    <p>Solte a foto</p>
                                    <p>ou</p>
                                    <p><label class="imgLabel" for="imgInput">Click Aqui</label></p>
                                    <input type="file" id="imgInput" class="imgInput" name="imgInput">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="newCategoryButton">
                    <span class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</span>
                    <span id="sendCategory2" class="newCategoryButtonDisabled"
                        onclick="nextNewItem('AddOs')">Próximo</span>
                </div>
            </div>
            <div class="addos">
                <div>
                    <div class="addOsTitleBox">
                        <div class="addOsTitle">
                            <h3>
                                Complementos
                            </h3>
                        </div>
                        <div class="addOsSubTitle">
                            Seu Item tem Complementos?
                        </div>
                    </div>
                    <div>
                        <div>
                            <input type="radio" name="addOs" id="addOsYes">
                            <label for="addOsYes">Sim, Este item tem complementos</label>
                        </div>
                        <div>
                            <input type="radio" name="addOs" id="addOsNo">
                            <label for="addOsNo">Não, Este item não tem complementos</label>
                        </div>
                    </div>
                </div>
                <div class="addOsBox">
                    <div class="addOsBoxButton" id="addOsSubCategory">
                        <div class="addOsBoxIcon">
                            <span class="plus">
                            </span>
                        </div>
                        <div class="addOsBoxTitle">
                            Categoria
                        </div>
                    </div>
                    <div class="addOsBoxButton" id="addOsSubUser">
                        <div class="addOsBoxIcon">
                            <span class="copy">
                            </span>
                        </div>
                        <div class="addOsBoxTitle">
                            Usar complemento pronto
                        </div>
                    </div>
                </div>
                <div>
                    <div class="newCategoryButton">
                        <div class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</div>
                        <div id="sendCategory" class="newCategoryButtonDisabled" onclick="nextNewItem('rating')">
                            Próximo</d>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rating">
                <div>
                    <div class="addOsTitleBox">
                        <div class="addOsTitle">
                            <h3>
                                Restrições alimentares
                            </h3>
                        </div>
                        <div class="addOsSubTitle">
                            Indique se seu item é adequado a restrições alimentares diversas para atrair a atenção
                            do clientes
                        </div>
                    </div>
                    <div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="ratingProduct" id="Vegetarian">
                            <label for="Vegetarian">Vegetariano</label>
                            <span class="infoBox" title="Sem carne de nenhum tipo">
                                <span class="info"></span>
                            </span>
                        </div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="ratingProduct" id="Vegan">
                            <label for="Vegan">Vegano</label>
                            <span class="infoBox" title="Sem produtos de origem animal como carne, ovo ou leite">
                                <span class="info"></span>
                            </span>
                        </div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="ratingProduct" id="Organic">
                            <label for="Organic">Orgânico</label>
                            <span class="infoBox" title="Cultivado sem agrotóxicos, segundo a lei 10.831">
                                <span class="info"></span>
                            </span>
                        </div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="ratingProduct" id="noGluten">
                            <label for="noGluten">Sem Glúten</label>
                            <span class="infoBox" title="Não Contém a proteína do glúten">
                                <span class="info"></span>
                            </span>
                        </div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="ratingProduct" id="noSugar">
                            <label for="noSugar">Sem Açúcar</label>
                            <span class="infoBox" title="Não contém nenhum tipo de açúcar">
                                <span class="info"></span>
                            </span>
                        </div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="ratingProduct" id="noLactose">
                            <label for="noLactose">Zero lactose</label>
                            <span class="infoBox" title="Não contém leite ou derivados">
                                <span class="info"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="newCategoryButton">
                        <div class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</div>
                        <div id="sendCategory" class="newCategoryButtonDisabled"
                            onclick="nextNewItem('availability')">
                            Próximo</d>
                        </div>
                    </div>
                </div>
            </div>
            <div class="availability">
                <div>
                    <div>
                        <div class="addOsTitleBox">
                            <div class="addOsTitle">
                                <h3>
                                    Disponibilidade
                                </h3>
                            </div>
                            <div class="addOsSubTitle">
                                Aqui você define em que momentos os clientes poderão comprar este item
                            </div>
                        </div>
                        <div>
                            <div>
                                <input type="radio" name="availabilityRadio" id="availabilityRadioYes">
                                <label for="availabilityRadioYes">Sempre disponível</label>
                                <span class="infoBox"
                                    title="O item ficará disponível sempre que o restaurante estiver aberto">
                                    <span class="info"></span>
                                </span>
                            </div>
                            <div>
                                <input type="radio" name="availabilityRadio" id="availabilityRadioNo">
                                <label for="availabilityRadioNo">Disponível em dias e horários específicos</label>
                                <span class="infoBox" title="Selecione os períodos em que o item ficará disponível">
                                    <span class="info"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="viewTurn">
                </div>

                <div class="turnButton categoryButtonItem">
                    <span class="plus"></span>
                    Adicionar turno
                </div>

                <div class="boxTurn">
                    <div class="boxTurn2">
                        <div>
                            <h2 for="turn1In" id="turnNumber">1° Turno </h2>
                        </div>
                        <div class="turnDay">
                            <div>
                                Dias da semana
                            </div>
                            <div>
                                <span title="Domingo" class="sundayTurn" onclick="turnDaySend('sundayTurn');">
                                    D
                                </span>
                                <span title="Segunda" class="mondayTurn" onclick="turnDaySend('mondayTurn');">
                                    S
                                </span>
                                <span title="Terça" class="thirdTurn" onclick="turnDaySend('thirdTurn');">
                                    T
                                </span>
                                <span title="Quarta" class="fourthTurn" onclick="turnDaySend('fourthTurn');">
                                    Q
                                </span>
                                <span title="Quinta" class="thursdayTurn" onclick="turnDaySend('thursdayTurn');">
                                    Q
                                </span>
                                <span title="Sexta" class="fridayTurn" onclick="turnDaySend('fridayTurn');">
                                    S
                                </span>
                                <span title="Sabado" class="saturdayTurn" onclick="turnDaySend('saturdayTurn');">
                                    S
                                </span>
                            </div>
                        </div>
                        <div class="turnHour">
                            <div class="turnTitle">
                                <div>
                                    Horários
                                </div>
                            </div>
                            <div class="turn">
                                <div>
                                    <select name="turn1In" id="turn1In">
                                        <option value="00:00">00:00</option>
                                        <option value="00:15">00:15</option>
                                        <option value="00:30">00:30</option>
                                        <option value="00:45">00:45</option>
                                        <option value="01:00">01:00</option>
                                        <option value="01:15">01:15</option>
                                        <option value="01:30">01:30</option>
                                        <option value="01:45">01:45</option>
                                        <option value="02:00">02:00</option>
                                        <option value="02:15">02:15</option>
                                        <option value="02:30">02:30</option>
                                        <option value="02:45">02:45</option>
                                        <option value="03:00">03:00</option>
                                        <option value="03:15">03:15</option>
                                        <option value="03:30">03:30</option>
                                        <option value="03:45">03:45</option>
                                        <option value="04:00">04:00</option>
                                        <option value="04:15">04:15</option>
                                        <option value="04:30">04:30</option>
                                        <option value="04:45">04:45</option>
                                        <option value="05:00">05:00</option>
                                        <option value="05:15">05:15</option>
                                        <option value="05:30">05:30</option>
                                        <option value="05:45">05:45</option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:15">06:15</option>
                                        <option value="06:30">06:30</option>
                                        <option value="06:45">06:45</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:15">07:15</option>
                                        <option value="07:30">07:30</option>
                                        <option value="07:45">07:45</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:15">08:15</option>
                                        <option value="08:30">08:30</option>
                                        <option value="08:45">08:45</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:15">09:15</option>
                                        <option value="09:30">09:30</option>
                                        <option value="09:45">09:45</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:15">10:15</option>
                                        <option value="10:30">10:30</option>
                                        <option value="10:45">10:45</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:15">11:15</option>
                                        <option value="11:30">11:30</option>
                                        <option value="11:45">11:45</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:15">12:15</option>
                                        <option value="12:30">12:30</option>
                                        <option value="12:45">12:45</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:15">13:15</option>
                                        <option value="13:30">13:30</option>
                                        <option value="13:45">13:45</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:15">14:15</option>
                                        <option value="14:30">14:30</option>
                                        <option value="14:45">14:45</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:15">15:15</option>
                                        <option value="15:30">15:30</option>
                                        <option value="15:45">15:45</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:15">16:15</option>
                                        <option value="16:30">16:30</option>
                                        <option value="16:45">16:45</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:15">17:15</option>
                                        <option value="17:30">17:30</option>
                                        <option value="17:45">17:45</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:15">18:15</option>
                                        <option value="18:30">18:30</option>
                                        <option value="18:45">18:45</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:15">19:15</option>
                                        <option value="19:30">19:30</option>
                                        <option value="19:45">19:45</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:15">20:15</option>
                                        <option value="20:30">20:30</option>
                                        <option value="20:45">20:45</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:15">21:15</option>
                                        <option value="21:30">21:30</option>
                                        <option value="21:45">21:45</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:15">22:15</option>
                                        <option value="22:30">22:30</option>
                                        <option value="22:45">22:45</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:15">23:15</option>
                                        <option value="23:30">23:30</option>
                                        <option value="23:45">23:45</option>
                                    </select>
                                </div>
                                <div>
                                    <select name="turn1Out" id="turn1Out">
                                        <option value="00:00">00:00</option>
                                        <option value="00:15">00:15</option>
                                        <option value="00:30">00:30</option>
                                        <option value="00:45">00:45</option>
                                        <option value="01:00">01:00</option>
                                        <option value="01:15">01:15</option>
                                        <option value="01:30">01:30</option>
                                        <option value="01:45">01:45</option>
                                        <option value="02:00">02:00</option>
                                        <option value="02:15">02:15</option>
                                        <option value="02:30">02:30</option>
                                        <option value="02:45">02:45</option>
                                        <option value="03:00">03:00</option>
                                        <option value="03:15">03:15</option>
                                        <option value="03:30">03:30</option>
                                        <option value="03:45">03:45</option>
                                        <option value="04:00">04:00</option>
                                        <option value="04:15">04:15</option>
                                        <option value="04:30">04:30</option>
                                        <option value="04:45">04:45</option>
                                        <option value="05:00">05:00</option>
                                        <option value="05:15">05:15</option>
                                        <option value="05:30">05:30</option>
                                        <option value="05:45">05:45</option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:15">06:15</option>
                                        <option value="06:30">06:30</option>
                                        <option value="06:45">06:45</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:15">07:15</option>
                                        <option value="07:30">07:30</option>
                                        <option value="07:45">07:45</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:15">08:15</option>
                                        <option value="08:30">08:30</option>
                                        <option value="08:45">08:45</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:15">09:15</option>
                                        <option value="09:30">09:30</option>
                                        <option value="09:45">09:45</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:15">10:15</option>
                                        <option value="10:30">10:30</option>
                                        <option value="10:45">10:45</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:15">11:15</option>
                                        <option value="11:30">11:30</option>
                                        <option value="11:45">11:45</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:15">12:15</option>
                                        <option value="12:30">12:30</option>
                                        <option value="12:45">12:45</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:15">13:15</option>
                                        <option value="13:30">13:30</option>
                                        <option value="13:45">13:45</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:15">14:15</option>
                                        <option value="14:30">14:30</option>
                                        <option value="14:45">14:45</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:15">15:15</option>
                                        <option value="15:30">15:30</option>
                                        <option value="15:45">15:45</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:15">16:15</option>
                                        <option value="16:30">16:30</option>
                                        <option value="16:45">16:45</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:15">17:15</option>
                                        <option value="17:30">17:30</option>
                                        <option value="17:45">17:45</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:15">18:15</option>
                                        <option value="18:30">18:30</option>
                                        <option value="18:45">18:45</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:15">19:15</option>
                                        <option value="19:30">19:30</option>
                                        <option value="19:45">19:45</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:15">20:15</option>
                                        <option value="20:30">20:30</option>
                                        <option value="20:45">20:45</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:15">21:15</option>
                                        <option value="21:30">21:30</option>
                                        <option value="21:45">21:45</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:15">22:15</option>
                                        <option value="22:30">22:30</option>
                                        <option value="22:45">22:45</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:15">23:15</option>
                                        <option value="23:30">23:30</option>
                                        <option value="23:45">23:45</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="newTurnButton">
                            <div class="newCategoryButtonCancel" onclick="closeTurn()">Cancelar</div>
                            <div id="sendCategory" class="newCategoryButtonDisabled" onclick="sendTurn()">
                                Próximo</d>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="newCategoryButton">
                        <div class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</div>
                        <div id="sendCategory" class="newCategoryButtonDisabled" onclick="sendItem()">
                            Próximo</d>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="newAddOs" class="menuRight">
        <div class="newSubCategoryTitle">
            Adicionar complementos a esta categoria
        </div>
        <form id="newItemCategory" method="post" enctype="multipart/form-data" class="newSubCategoryBox3">
            <input type="hidden" name="newItemCategoryId" id="newItemCategoryId">
            <div class="newItemBox">
                <div class="newSubCategoryNamePreco">
                    <div>
                        <label for="itemName">Nome</label>
                        <input class="newItemInput" type="text" placeholder="X-Tudo" name="newItemCategoryName"
                            id="SubCategoryItemName2">
                    </div>
                    <div>
                        <label for="itemSale">Preço</label>
                        <input class="newItemInput" type="text" name="newItemCategorySale" id="newItemCategorySale2"
                            placeholder="R$ 99,99">
                    </div>
                </div>
                <label for="Description">Descrição</label>
                <textarea class="newItemInput" name="newItemCategoryDescription" id="newItemCategoryDescription"
                    rows="7"
                    placeholder="Exemplo: Pão, Carne,queijo, Ovo, Bacon, Presunto, Alface, Tomate, Cheddar, Requeijão, Banana, Calabresa, Milho e Batata Palha."></textarea>
                <label for="newItemCategoryPVD">Código PDV</label>
                <input class="newItemInput" type="text" name="newItemCategoryPVD" id="newItemCategoryPVD">
            </div>
            <div class="newItemBox">
                <p>Imagem de capa</p>
                <h6>Aparece na listagem e no detalhe do prato</h6>
                <div id="drop_file_zone2" ondrop="upload_file2(event)" ondragover="return false">
                    <img src="" id="itemImageShow2" alt="">
                    <div id="drag_upload_file2">
                        <p>Solte a foto</p>
                        <p>ou</p>
                        <p><label class="imgLabel2" for="imgInput2">Click Aqui</label></p>
                        <input type="file" id="imgInputNewSub2" class="imgInput2" name="imgInput2">
                    </div>
                </div>
            </div>
        </form>
        <div>
            <div class="newCategoryButton">
                <span class="newCategoryButtonCancel" onclick="closeWindow3()">Cancelar</span>
                <span id="sendSubCategory3" onclick="send('newItemCategory')"
                    class="newCategoryButtonDisabled">Salvar</span>
            </div>
        </div>
    </div>

    <div id="newSubCategory" class="menuRight">
        <div id="navItens" class="marginSubNav">
            <div class="subMenu">
                <div class="subMenuTitle subDetails subMenuactive">
                    Detalhes
                </div>
                <div class="subMenuTitle subAddOs">
                    Complementos
                </div>
            </div>
        </div>
        <form method="post" id="insertSubCategory">
            <div class="newSubCategoryBox1">
                <div>
                    <div class="viewInputBox">
                        <h2>
                            Novo grupo de complementos
                        </h2>
                        <div class="viewInput2">
                            <input type="text" id="editNameSubCategory" class="newItemInput" name="editNameSubCategory"
                                placeholder="Nome">
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        Essa categoria é nescessaria para pedir o prato?
                    </div>
                    <div class="newSubCategoryRadio">
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="subCategoryRange" id="newSubCategoryOptional" value="optional">
                            <label for="newSubCategoryOptional">Opcional</label>
                            <span class="infoBox" title="O cliente pode ou não selecionar os itens">
                                <span class="info"></span>
                            </span>
                        </div>
                        <div class="newSubCategoryRadioBox">
                            <input type="radio" name="subCategoryRange" id="newSubCategoryRequired" value="required">
                            <label for="newSubCategoryRequired">Obrigatório</label>
                            <span class="infoBox"
                                title=" cliente deve selecionar no minimo 1 item para adicionar o pedido no carrinho">
                                <span class="info"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div>
                            Quantidade
                        </div>
                        <div>
                            Indique quantos itens podem ser selecionados
                        </div>
                        <div class="newSubCategoryRange">
                            <div>
                                <h4>
                                    Mínimo
                                    <input type="hidden" name="subCategoryRange1" id="subCategoryRange1">
                                </h4>
                                <div id="newSubCategoryRangeMin">
                                    <span class="minus" onclick="subCategoryRangeMin1()"></span>
                                    <span id="subCategoryRangeView1">0</span>
                                    <span onclick="subCategoryRangeMax1()" class="plus"></span>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <h4>
                                        Máximo
                                        <input type="hidden" name="subCategoryRange2" id="subCategoryRange2">
                                    </h4>
                                </div>
                                <div id="newSubCategoryRangeMax">
                                    <span class="minus" onclick="subCategoryRangeMin2()"></span>
                                    <span id="subCategoryRangeView2">0</span>
                                    <span onclick="subCategoryRangeMax2()" class="plus"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="newCategoryButton">
                        <span class="newCategoryButtonCancel2">Cancelar</span>
                        <span id="sendSubCategory" onclick="sendSubCategory()"
                            class="newCategoryButtonDisabled">Próximo</sp>
                    </div>
                </div>
            </div>
            <div class="newSubCategoryBox2">
                <div class="newSubCategoryTitle">
                    Adicionar complementos a esta categoria
                </div>
                <div class="newSubCategoryBox3">
                    <div class="newItemBox">
                        <div class="newSubCategoryNamePreco">
                            <div>
                                <label for="itemName">Nome</label>
                                <input class="newItemInput" type="text" placeholder="X-Tudo" name="itemName"
                                    id="SubCategoryItemName">
                            </div>
                            <div>
                                <label for="itemSale">Preço</label>
                                <input class="newItemInput" type="text" name="itemSale" id="SubCategoryItemSale"
                                    placeholder="R$ 99,99">
                            </div>
                        </div>
                        <label for="Description">Descrição</label>
                        <textarea class="newItemInput" name="Description" id="SubCategoryItemDescription" rows="7"
                            placeholder="Exemplo: Pão, Carne,queijo, Ovo, Bacon, Presunto, Alface, Tomate, Cheddar, Requeijão, Banana, Calabresa, Milho e Batata Palha."></textarea>
                        <label for="PDV">Código PDV</label>
                        <input class="newItemInput" type="text" name="PVD" id="SubCategoryItemPDV">
                    </div>
                    <div class="newItemBox">
                        <p>Imagem de capa</p>
                        <h6>Aparece na listagem e no detalhe do prato</h6>
                        <div id="drop_file_zone2" ondrop="upload_file2(event)" ondragover="return false">
                            <img src="" id="itemImageShow2" alt="">
                            <div id="drag_upload_file2">
                                <p>Solte a foto</p>
                                <p>ou</p>
                                <p><label class="imgLabel2" for="imgInput2">Click Aqui</label></p>
                                <input type="file" id="imgInput2" class="imgInput2" name="imgInput2">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="newCategoryButton">
                        <span class="newCategoryButtonCancel">Cancelar</span>
                        <span id="sendSubCategory2" class="newCategoryButtonDisabled"
                            onclick="send('insertSubCategory')">Salvar</span>
                    </div>
                </div>
            </div>
        </form>
        <form id="insertNewSubCategory" action="insert_sub_category.php" method="post" enctype="multipart/form-data">
            <input id="editNameSubCategory2" type="hidden" name="editNameSubCategory" value="">
            <input id="subCategoryRange" type="hidden" name="subCategoryRange" value="">
            <input id="SubCategoryRangeMin" type="hidden" name="SubCategoryRangeMin" value="">
            <input id="SubCategoryRangeMax" type="hidden" name="SubCategoryRangeMax" value="">
            <input id="SubCategoryName" type="hidden" name="SubCategoryName" value="">
            <input id="SubCategorySale" type="hidden" name="SubCategorySale" value="">
            <input id="SubCategoryDescription" type="hidden" name="SubCategoryDescription" value="">
            <input id="SubCategoryPDV" type="hidden" name="SubCategoryPDV" value="">
            <input type="file" id="imgInput3" class="imgInput3" name="imgInput3">
        </form>
    </div>

    <div id="delItem" class="menuRight">
        <div class="flexTitle title">
            <div>
                Remover categoria
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div class="vh100">
            <div>
                <div>
                    <form id="categoryChageDelItem" method="post">
                        <div class="viewInputBox">
                            <h2>
                                Desejá Remover complemento
                                <span id="categoryNameDel2"></span>?
                            </h2>
                            <div>
                                <input type="hidden" class="inputView" id="delNameCategoryID2" name="delNameCategoryID">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="newCategoryButton">
            <button class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</button>
            <button id="editNameCategory" class="newCategoryButtonEnabled"
                onclick="send2('categoryChageDelItem')">Remover</button>
        </div>
    </div>

    <div id="delSubCategory" class="menuRight">
        <div class="flexTitle title">
            <div>
                Remover categoria
            </div>
            <div class="newCategoryButtonCancelX">
                <span class="xmark" onclick="closeWindow()">
                </span>
            </div>
        </div>
        <div class="vh100">
            <div>
                <div>
                    <form id="categorySubDelItem" method="post">
                        <div class="viewInputBox">
                            <h2>
                                Desejá Remover
                                <span id="categoryNameDel3"></span>?
                            </h2>
                            <div>
                                <input type="hidden" class="inputView" id="delNameCategoryID3" name="delNameCategoryID">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="newCategoryButton">
            <button class="newCategoryButtonCancel" onclick="closeWindow()">Cancelar</button>
            <button id="editNameCategory" class="newCategoryButtonEnabled"
                onclick="send2('categorySubDelItem')">Remover</button>
        </div>
    </div>

    <div id="userSubCategory" class="menuRight">
    </div>
</div>
</div>
<script src="js/category.js"></script>