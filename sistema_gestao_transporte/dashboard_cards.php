<!-- TRANSPORTE -->
            <div class="col-md-3 col-sm-6">
                <div class="payment--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="titlle">TRANSPORTE</span><br>
                            <?php
                                $query = "SELECT SUM(ValorTransporte) AS total FROM meetchegadas";
                                $result = mysqli_query($conexao, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo number_format($row['total'], 2, ',', '.') . " KZ<br><br>";
                            ?>
                        </div>
                        <i class="fas fa-truck icon"></i>
                    </div>
                    <span class="card-detail">Viaturas</span>
                </div>
            </div>

            <!-- SME EMBARQUES -->
            <div class="col-md-3 col-sm-6">
                <div class="payment--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="titlle">SME EMBARQUES</span><br>
                            <?php
                                $query = "SELECT SUM(ValorEmbarque) AS total FROM meetpartida";
                                $result = mysqli_query($conexao, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo number_format($row['total'], 2, ',', '.') . " KZ<br><br>";
                            ?>
                        </div>
                        <i class="fas fa-plane-departure icon"></i>
                    </div>
                    <span class="card-detail">SME EMBARQUES</span>
                </div>
            </div>

            <!-- SME DESEMBARQUES -->
            <div class="col-md-3 col-sm-6">
                <div class="payment--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="titlle">SME DESEMBARQUES</span><br>
                            <?php
                                $query = "SELECT SUM(ValorDesembarque) AS total FROM meetchegadas";
                                $result = mysqli_query($conexao, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo number_format($row['total'], 2, ',', '.') . " KZ<br><br>";
                            ?>
                        </div>
                        <i class="fas fa-plane-arrival icon"></i>
                    </div>
                    <span class="card-detail">SME DESEMBARQUES</span>
                </div>
            </div>

            <!-- SONILS EMBARQUES -->
            <div class="col-md-3 col-sm-6">
                <div class="payment--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="titlle">SONILS EMBARQUES</span><br>
                            <?php
                                $query = "SELECT SUM(ValorAcesso) AS total FROM meetpartida";
                                $result = mysqli_query($conexao, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo number_format($row['total'], 2, ',', '.') . " KZ<br><br>";
                            ?>
                        </div>
                        <i class="fas fa-anchor icon"></i>
                    </div>
                    <span class="card-detail">SONILS EMBARQUES</span>
                </div>
            </div>

            <!-- SONILS DESEMBARQUES -->
            <div class="col-md-3 col-sm-6">
                <div class="payment--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="titlle">SONILS DESEMBARQUES</span><br>
                            <?php
                                $query = "SELECT SUM(ValorAcesso) AS total FROM meetchegadas";
                                $result = mysqli_query($conexao, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo number_format($row['total'], 2, ',', '.') . " KZ<br><br>";
                            ?>
                        </div>
                        <i class="fas fa-anchor icon"></i>
                    </div>
                    <span class="card-detail">SONILS DESEMBARQUES</span>
                </div>
            </div>

            <!-- CAPITANIA -->
            <div class="col-md-3 col-sm-6">
                <div class="payment--card">
                    <div class="card--header">
                        <div class="amount">
                            <span class="titlle">CAPITANIA</span><br>
                            <?php
                                $query = "SELECT SUM(ValorCapitania) AS total FROM meetpartida";
                                $result = mysqli_query($conexao, $query);
                                $row = mysqli_fetch_assoc($result);
                                echo number_format($row['total'], 2, ',', '.') . " KZ<br><br>";
                            ?>
                        </div>
                        <i class="fas fa-ship icon"></i>
                    </div>
                    <span class="card-detail">Capitania IMPA</span>
                </div>
            </div>
        </div>