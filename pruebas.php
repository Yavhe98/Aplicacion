<form action="#" method="POST">

                        <div class="row">

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="selector">Edificio:</label>
                                    <select class="form-control" id="edificio" name="edificio">
                                        <option selected value="citic">Citic</option>
                                        <option value="cmaximo">Cmaximo</option>
                                        <option value="instrumentacion">Instrumentacion</option>
                                        <option value="mentecerebro">Mente y Cerebro</option>
                                        <option value="politecnico">Politecnico</option>
                                        <option value="politicas">Politicas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="btn-add">Añadir placa</button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger" id="btn-remove">Quitar placa</button>
                                </div>

                                <span id="counter"><?php echo $_POST["counter"];?></span>
                                <input type="hidden" name="counter" id="counter-input">

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>


                        <script>
                            $(document).ready(function () {
                                var counter = <?php echo json_encode($_POST["counter"]); ?>;

                                $("#btn-add").click(function () {
                                    counter++;
                                    $("#counter").text(counter);
                                });

                                $("#btn-remove").click(function () {
                                    if (counter > 0) {
                                        counter--;
                                        $("#counter").text(counter);
                                    }
                                });

                            });

                            document.addEventListener("DOMContentLoaded", function () {
                                var counter = 0;
                                var counterElement = document.getElementById("counter");
                                var counterInput = document.getElementById("counter-input");
                                var btnAdd = document.getElementById("btn-add");
                                var btnRemove = document.getElementById("btn-remove");

                                btnAdd.addEventListener("click", function () {
                                    counter++;
                                    counterElement.textContent = counter;
                                });

                                btnRemove.addEventListener("click", function () {
                                    if (counter > 0) {
                                        counter--;
                                        counterElement.textContent = counter;
                                    }
                                });

                                document.querySelector("form").addEventListener("submit", function () {
                                    counterInput.value = counter;
                                });
                            });
                        </script>