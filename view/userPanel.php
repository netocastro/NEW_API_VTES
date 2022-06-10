<?php

if (isset($_SESSION['user_id'])) :  ?>

      <?php $v->layout('_template'); ?>

      <div class="container-lg mb-5">
            <div class="row my-5">
                  <div class="col-md-4 border border-warning">
                        <div class="row mb-2">
                              <form id="form-deck-update" action="<?= $route->route("deck.updateDeck") ?>" method="POST" data-type="JSON">
                                    <!-- resolver isso e usar o puao invez do post -->
                                    <div class="me-1">Decks: </div>
                                    <div class="d-grid gap-2">
                                          <select id="change-deck" class="form-control form-control-sm" data-action="<?= $route->route("deck.showByDeckId"); ?>" data-method="POST" data-type="JSON" name="deckNameUpdate">
                                                <option value="--"> -- </option>
                                                <?php foreach ($userDecks as $deck) : ?>
                                                      <option value="<?= $deck->id ?>"><?= $deck->name ?></option>
                                                <?php endforeach; ?>
                                          </select>
                                          <button class="btn btn-outline-success btn-sm ms-1" id="update-deck" type="submit">atualizar</button>
                                    </div>
                              </form>
                        </div>
                        <div class="d-grid">
                              <button class="btn btn-dark" id="decktxt" data-action="<?= $route->route('request.deckTxt'); ?>" data-method="POST" data-type="JSON">exportar para .txt</button>
                        </div>
                        <div class="row mb-2">
                              <form id="form-deck-save" action="<?= $route->route("deck.createDeck") ?>" method="POST" data-type="JSON">
                                    <div class="me-1">New deck: </div>
                                    <input type="text" class="form-control form-control-sm" name="deckName" id="deckName">
                                    <div class="d-grid">
                                          <button type="submit" class="btn btn-outline-success btn-sm ms-1" id="save-deck">Salvar</button>
                                    </div>
                              </form>
                        </div>
                        <div class="row mb-2 px-3">
                              <div class="col-12 mt-2 trash d-flex justify-content-center align-items-center" id="drop-area">
                                    <i class="fas fa-trash-alt h1"></i>
                              </div>
                        </div>
                        <div class="row border border-success">
                              <div class="col-12">
                                    <img src="cdn/media/images/cardImages/cardbackcrypt.jpg" alt="" class="img-fluid" id="img-card">
                                    <input type="hidden" data-action="<?= $route->route('request.cardImage'); ?>" data-method="GET" data-type="JSON" id="image">
                              </div>
                        </div>
                  </div>
                  <div class="col-md-8 ">
                        <!-- <div class="row d-flex justify-content-around mt-2 align-items-center border">
                              <div class="col-sm-6 d-flex align-items-center justify-content-center border">
                                    <form id="form-deck-update" action="<?= $route->route("deck.updateDeck") ?>" method="POST" data-type="JSON">
                                           resolver isso e usar o puao invez do post 
                                          <div class="me-1">Decks: </div>
                                          <div class="d-grid gap-2">
                                                <select id="change-deck" class="form-control form-control-sm" data-action="<?= $route->route("deck.showByDeckId"); ?>" data-method="POST" data-type="JSON" name="deckNameUpdate">
                                                      <option value="--"> -- </option>
                                                      <?php foreach ($userDecks as $deck) : ?>
                                                            <option value="<?= $deck->id ?>"><?= $deck->name ?></option>
                                                      <?php endforeach; ?>
                                                </select>

                                                <button class="btn btn-outline-success btn-sm ms-1" id="update-deck" type="submit">atualizar</button>
                                          </div>

                                    </form>
                              </div>
                              <div class="col-sm-6 d-flex align-items-center border">
                                    <form id="form-deck-save" action="<?= $route->route("deck.createDeck") ?>" method="POST" data-type="JSON">
                                          <div class="me-1">New deck: </div>

                                          <input type="text" class="form-control form-control-sm" name="deckName" id="deckName">
                                          <div class="d-grid">
                                                <button type="submit" class="btn btn-outline-success btn-sm ms-1" id="save-deck">Salvar</button>
                                          </div>
                                    </form>
                              </div>
                        </div> -->
                        <div class="row mt-2">
                              <div class="col-12">
                                    <div class=" rounded p-2 h-100 ">
                                          <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                                                <li class="nav-item " role="presentation">
                                                      <button class="nav-link active" id="library-tab" data-bs-toggle="tab" data-bs-target="#library" type="button" role="tab" aria-controls="library" aria-selected="true">Library <span id="total-library"></span></button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link" id="crypt-tab" data-bs-toggle="tab" data-bs-target="#crypt" type="button" role="tab" aria-controls="crypt" aria-selected="false">Crypt <span id="total-crypt"></span></button>
                                                </li>
                                          </ul>
                                          <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active mt-3" id="library" role="tabpanel" aria-labelledby="library-tab" style="overflow: auto; width: 100%; height: 300px;">
                                                      <table class="table table-sm">
                                                            <thead>
                                                                  <tr>
                                                                        <th scope="col"># </th>
                                                                        <th scope="col">Name</th>
                                                                        <th scope="col">type</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody id="library-deck">
                                                            </tbody>
                                                      </table>
                                                </div>
                                                <div class="tab-pane fade" id="crypt" role="tabpanel" aria-labelledby="crypt-tab" style="overflow: auto; width: 100%; height: 300px;">
                                                      <table class="table table-sm">
                                                            <thead>
                                                                  <tr>
                                                                        <th scope="col"># </th>
                                                                        <th scope="col">Name</th>
                                                                        <th scope="col">cla</th>
                                                                        <th scope="col">capacity</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody id="crypt-deck">
                                                            </tbody>
                                                      </table>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <!-- todas as caras do vtes -->
                        <div class="row">
                              <div class="col-12 p-2">
                                    <ul class="nav nav-pills nav-fill " id="pills-tab" role="tablist">
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-all-library-tab" data-bs-toggle="pill" data-bs-target="#all-library-cards" type="button" role="tab" aria-controls="pills-all-library" aria-selected="true">Library</button>
                                          </li>
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-all-crypt-tab" data-bs-toggle="pill" data-bs-target="#all-crypt-cards" type="button" role="tab" aria-controls="pills-all-crypt" aria-selected="false">Crypt</button>
                                          </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                          <!-- Todas as cartas de livraria -->
                                          <div class="tab-pane fade show active mt-3" id="all-library-cards" role="tabpanel" aria-labelledby="pills-home-tab">
                                                <div class="row mb-1 bg-success text-light rounded ms-1" style="width: 99%;">
                                                      <div class="col-md-12 rounded">
                                                            <div class="row py-1">
                                                                  <div class="col-md-4">
                                                                        <input type="text" id="find-library" name="find-library" class="form-control" placeholder="Find name">
                                                                  </div>
                                                                  <div class="col-md-4 ">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text">
                                                                                    <input class="form-check-input" type="checkbox" id="type">
                                                                              </div>
                                                                              <input type="text" class="form-control " disabled id="library-input-type" placeholder="Find type">
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text">
                                                                                    <input class="form-check-input" type="checkbox" id="text">
                                                                              </div>
                                                                              <input type="text" class="form-control" disabled id="library-input-text" placeholder="Find text">
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="row mb-5">
                                                      <div class="col-md-12  rounded table-responsive ms-3" style="overflow-y: scroll; width: 96%; height: 250px;">
                                                            <table class="table table-sm table-responsive">
                                                                  <thead class="sticky-top bg-light">
                                                                        <tr>
                                                                              <th>Name</th>
                                                                              <th>Type</th>
                                                                              <th>Clan</th>
                                                                              <th>Discipline</th>
                                                                              <th>Pool_cost</th>
                                                                              <th>Blood_cost</th>
                                                                              <th>Set</th>
                                                                              <th>Card Text</th>
                                                                        </tr>
                                                                  </thead>
                                                                  <tbody id="list-all-library">
                                                                        <?php foreach ($libraryCards as $libraryCard) : ?>
                                                                              <tr data-id="<?= $libraryCard->id; ?>" draggable="true" class="tr" data-src=<?= $libraryCard->cardName(); ?>>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->name; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->type; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->clan; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->discipline; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->pool_cost; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->blood_cost; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->set; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $libraryCard->card_text; ?></td>
                                                                              </tr>
                                                                        <?php endforeach; ?>
                                                                  </tbody>
                                                            </table>
                                                      </div>
                                                </div>
                                          </div>
                                          <!-- Todas as cartas de cripta -->
                                          <div class="tab-pane fade mt-3" id="all-crypt-cards" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                <div class="row mb-1 bg-success text-light rounded ms-1" style="width: 99%;">
                                                      <div class="col-md-12 rounded">
                                                            <div class="row py-1">
                                                                  <div class="col-md-4">
                                                                        <input type="text" id="find-crypt" name="find-crypt" class="form-control " placeholder="Find name">
                                                                  </div>
                                                                  <div class="col-md-4 ">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text">
                                                                                    <input class="form-check-input" type="checkbox" id="type">
                                                                              </div>
                                                                              <input type="text" class="form-control " disabled id="crypt-input-type" placeholder="Find type">
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text">
                                                                                    <input class="form-check-input" type="checkbox" id="text">
                                                                              </div>
                                                                              <input type="text" class="form-control " disabled id="crypt-input-text" placeholder="Find text">
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="row mb-5">
                                                      <div class="col-md-12  rounded table-responsive ms-3" style="overflow-y: scroll; width: 96%; height: 250px;">
                                                            <table class="table table-sm table-responsive">
                                                                  <thead class="sticky-top bg-light">
                                                                        <tr>
                                                                              <th>Name</th>
                                                                              <th>Type</th>
                                                                              <th>Clan</th>
                                                                              <th>ADV</th>
                                                                              <th>group</th>
                                                                              <th>capacity</th>
                                                                              <th>Discipline</th>
                                                                              <th>Set</th>
                                                                              <th>Card Text</th>
                                                                        </tr>
                                                                  </thead>
                                                                  <tbody id="list-all-crypt">
                                                                        <?php foreach ($cryptCards as $cryptCard) : ?>
                                                                              <tr data-id="<?= $cryptCard->id; ?>" draggable="true" class="tr" data-src=<?= $cryptCard->cardName(); ?>>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->name; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->type; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->clan; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->adv; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->grupo(); ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->capacity; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->disciplines; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->set; ?></td>
                                                                                    <td style="white-space: nowrap;"><?= $cryptCard->card_text; ?></td>
                                                                              </tr>
                                                                        <?php endforeach; ?>
                                                                  </tbody>
                                                            </table>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
      <!--<div class="drop-area" style="border: 1px solid black; width: 200px; height: 200px;"> 
      </div> -->
      <?php $v->start('js'); ?>

      <script src="view/js/painelLogado.js"></script>
      <script src="view/js/userPanel.js"></script>
      <script src="view/js/saveDeck.js"></script>
      <script src="view/js/updateDeck.js"></script>

      <?php $v->end(); ?>

<?php else : $route->redirect('web.home');
endif ?>