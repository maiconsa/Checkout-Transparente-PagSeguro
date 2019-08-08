<?php if(!class_exists('Rain\Tpl')){exit;}?>

<h3>Sender Register</h3>

        <form  class="col" >
            <div class="form-row  ">
                <div class="form-group col">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="José Comprado">
                </div>
            </div>

            <div class="form-row  ">
                <div class="form-group col">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" value="22111944785" maxlength="11">
                </div>
            </div>
            <div class="form-row  ">
                <div class="form-group col-lx-2">
                    <label for="areaCode">Area Code</label>
                    <input type="text" class="form-control" id="areaCode" name="areaCode"  placeholder="67" maxlength="2" value="67">
                </div>
                <div class="form-group col-lx-3">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="" maxlength="9" value="56273440">
                </div>
            </div>
            <div class="form-row ">
                <div class="form-group col">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="testando@sandbox.pagseguro.com.br">
                </div>
            </div>

            <div class="form-row ">
                <div class="form-group col">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Street" value="Av. Brig. Faria Lima">
                </div>
                <div class="form-group col-lx-1">
                    <label for="number">Number</label>
                    <input type="text" class="form-control" id="number" name="number" placeholder="Number" value="1384">
                </div>
            </div>
            <div class="form-row ">
                <div class="form-group col">
                    <label for="district">District</label>
                    <input type="text" class="form-control" id="district"  name="district" placeholder="District" value="Jardim Paulistano">
                </div>
                <div class="form-group ">
                    <label for="complement">Complement</label>
                    <input type="text" class="form-control" id="complement" name="complement" placeholder="Complement" value="5º Andar">
                </div>
            </div>
            <div class="form-row ">
                <div class="form-group col">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city"  name="city" value="São Paulo">
                </div>
                <div class="form-group col-lx-2">
                    <label for="sate">State</label>
                    <select id="sate" name="state" class="form-control">
                        <option selected>Choose...</option>
                        <?php require $this->checkTemplate("states");?>
                    </select>
                </div>
            </div>
            <div class="form-row ">
                <div class="form-group col-lx-2">
                    <label for="country">Country</label>
                    <input type="text"  class="form-control" name="country" id="country" value="BRA">
                </div>
                <div class="form-group col-lx-2">
                    <label for="postalCode">Postal Code</label>
                    <input type="text" class="form-control" name="postalCode" id="postalCode" value="01452002">
                </div>
            </div>
            <div class="form-row ">
                <div class="form-group col-lx-2">
                <button type="submit" formmethod="get" formaction="/sender/unregister" class="btn btn-primary">Remove</button>
                </div>
                <div class="form-group col-lx-2">
                    <button type="submit" formmethod="post" formaction="/create/sender"  class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>


