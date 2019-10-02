<br>

<div class="modal fade" id="admin_replay_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="admin_replay_form">
            	<div class="modal-body">
	                <div class="form-group">
	                    <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="email" name="email" class="form-control" id="recipient-email" readonly>
	                </div>
	                <div class="form-group">
	                    <label for="message-text" class="col-form-label">Message:</label>
	                    <textarea class="form-control" name="message" id="message-text"></textarea>
	                </div>
                	<input type="hidden" id="message_id" name="message_id">
            	</div>
            	<div class="modal-footer">
            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">Close</button>
                	<button type="submit" class="btn btn-primary">Send message</button>
            	</div>
            </form>
        </div>
    </div>
</div>