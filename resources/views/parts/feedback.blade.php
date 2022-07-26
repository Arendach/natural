<div data-toggle="modal" data-target="#feedback" class="feedback-open">
    <i class="fa fa-phone"></i>
    <span class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline">Перетелефонуйте мені</span>
</div>

<!-- Modal -->

<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartTitle">Перетелефонуйте мені</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('feedback.create') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="feedback-name">
                            <i class="text-danger">*</i> Ваше імя
                        </label>
                        <input
                                id="feedback-name"
                                required class="form-control form-control-sm"
                                name="name"
                                maxlength="255"
                        >
                    </div>
                    <div class="form-group">
                        <label for="feedback-phone">
                            <i class="text-danger">*</i> Ваш номер телефону
                        </label>
                        <input
                                id="feedback-phone"
                                pattern="^[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$"
                                required
                                class="form-control form-control-sm"
                                name="phone"
                        >
                    </div>
                    <div class="form-group">
                        <label for="feedback-message">Ваш коментар (не обов'язково)</label>
                        <textarea
                                maxlength="3000"
                                id="feedback-message"
                                class="form-control form-control-sm"
                                name="message"
                        ></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <button class="btn btn-sm btn-primary">Відправити заявку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
