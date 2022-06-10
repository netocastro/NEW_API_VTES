<?php $v->layout('_template'); ?>

<div class="d-flex justify-content-center">
    <h2 class="text-center my-3">Want list: <?= $name ?></h2>
    <div class=" d-none spinner-border text-success ms-3 mt-4 load" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<?php if (isset($_SESSION['user_id']) && $user->id == $_SESSION['user_id'] && $user->id == $_SESSION['user_id']) : ?>
    <div class="row no-spaces ">
        <div class="col-1 col-md-2 col-sm-1"></div>
        <div class="col-10 col-md-8 col-sm-10">
            <div class="row no-spaces">
                <div class="col-md-4 col-sm-4">
                    <select class="form-select form-select-sm" name="type-card" id="type-card" data-type="JSON" data-method="get" data-url="<?= $route->route('crypt.selectCryptForList'); ?>">
                        <option value="crypt">Crypt</option>
                        <option value="library">Library</option>
                    </select>
                </div>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="card-name" class="form-control form-control-sm" placeholder="Card name" list="list" id="input" autofocus>
                    <datalist id="list">
                        <?php foreach ($cryptCards as $cryptCard) : ?>
                            <option data-id="<?= $cryptCard->id ?>" data-src=<?= $cryptCard->cardName() ?> value="<?= $cryptCard->name . " " . ($cryptCard->adv  == 'Advanced' ? "adv" : "") ?>"><?= $cryptCard->clan ?></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="col-md-2 col-sm-2">
                    <button type="button" class="btn btn-outline-success btn-sm ms-1" id="save-want-list" data-url="<?= $route->route('request.saveWantList') ?>">Update</button>
                </div>
            </div>
        </div>
        <div class="col-1 col-md-2 col-sm-1"></div>
    </div>
<?php endif; ?>
<div class="row no-spaces">
    <div class="col-0 col-md-2 "></div>
    <div class="col-12 col-md-8 mt-3">
        <ul class="nav nav-pills nav-fill mb-3 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Crypt<span id="total-want-crypt"></span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Library<span id="total-want-library"></span></button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Clan</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="cryptList">
                        <?php if ($wantListCrypt) : ?>
                            <?php foreach ($wantListCrypt as $wantCrypt) : ?>
                                <tr data-id="<?= $wantCrypt->cryptCard()->id ?>">
                                    <td class="amount-crypt"><?= $wantCrypt->amount ?></td>
                                    <td class="card-name">
                                        <div class="d-grid">
                                            <button class="btn btn-link text-start" data-bs-toggle="modal" data-bs-target="#exampleModal" data-src=<?= $wantCrypt->cryptCard()->cardName(); ?>><?= trim($wantCrypt->cryptCard()->name); ?></button>
                                        </div>
                                    </td>
                                    <td><?= $wantCrypt->cryptCard()->clan ?></td>
                                    <?php if (isset($_SESSION['user_id']) && $user->id == $_SESSION['user_id']) : ?>
                                        <td class="text-center ">
                                            <div class="btn-group">
                                                <button class="btn btn-sm py-1" id="removeCrypt"><i class="fas fa-minus"></i></button>
                                                <button class="btn btn-sm me-1 py-1" id="addCrypt"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <?php if (isset($_SESSION['user_id']) && $user->id == $_SESSION['user_id']) : ?>
                                <th scope="col"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="libraryList">
                        <?php if ($wantListLibrary) : ?>
                            <?php foreach ($wantListLibrary as $wantLibrary) : ?>
                                <tr data-id="<?= $wantLibrary->libraryCard()->id ?>">
                                    <td class="amount-library"><?= $wantLibrary->amount ?></td>
                                    <td class="card-name">
                                        <div class="d-grid">
                                            <button class="btn btn-link text-start" data-bs-toggle="modal" data-bs-target="#exampleModal" data-src=<?= $wantLibrary->libraryCard()->cardName(); ?>><?= trim($wantLibrary->libraryCard()->name); ?></button>
                                        </div>
                                    </td>
                                    <td><?= $wantLibrary->libraryCard()->type ?></td>
                                    <?php if (isset($_SESSION['user_id']) && $user->id == $_SESSION['user_id']) : ?>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm py-1" id="removeLibrary"><i class="fas fa-minus"></i></button>
                                                <button class="btn btn-sm me-1 py-1" id="addLibrary"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-0 col-md-2"></div>
</div>

<!-- Modal -->
<div class="modal fade my-5" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-center d-flex justify-content-center align-items-center" style="width: 358px; height: 500px;">
        <img src="" alt="" id="image" class="d-none">
        <div class="bg-white d-flex justify-content-center align-items-center" style="width: 358px; height: 500px;" id="load-card">
            <div class="spinner-border text-success" role="status" id="load-card-image" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>

<?php $v->start('js'); ?>

<script src="<?= url('view/js/wantList.js'); ?>"></script>

<?php $v->end(); ?>