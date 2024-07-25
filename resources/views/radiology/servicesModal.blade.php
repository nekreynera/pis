<div id="addServices" class="modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center text-danger">Add a Radiology Service</h4>
      </div>
      <div class="modal-body">
          <form action="{{ url('radiology') }}" method="post" id="addServicesForm">
              {{ csrf_field() }}
              <div class="form-group">
                  <label>CATEGORY</label>
                  <select class="form-control" name="clinic_code" required>
                      <option value="">--Select Category--</option>
                      <option value="1034">X-RAY</option>
                      <option value="1033">ULTRASOUND</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>NAME/DESCRIPTION</label>
                  <textarea class="form-control" name="item_description" rows="3" placeholder="Enter Service Description..." required></textarea>
              </div>
              <div class="form-group">
                <label>PRICE</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><strong>&#8369;</strong></span>
                    <input type="number" name="price" min="0" class="form-control" placeholder="Enter Service Price" required />
                </div>
              </div>
              <div class="form-group">
                  <label>STATUS</label>
                  <select class="form-control" name="trash" required>
                      <option value="N">Active</option>
                      <option value="Y">In-Active</option>
                  </select>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" form="addServicesForm" class="btn btn-success">Save & Submit</button>
      </div>
    </div>

  </div>
</div>




<div id="editServices" class="modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center text-danger">Edit Radiology Service</h4>
      </div>
      <div class="modal-body">
          <form action="{{ url('radiologyEdit') }}" method="post" id="editServicesForm">
              {{ csrf_field() }}
              <input type="hidden" name="id" class="editID" />
              <div class="form-group">
                  <label>CATEGORY</label>
                  <select class="form-control" name="clinic_code" required>
                      <option value="">--Select Category--</option>
                      <option value="1034"  class="xray">X-RAY</option>
                      <option value="1033" class="ultrasound">ULTRASOUND</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>NAME/DESCRIPTION</label>
                  <textarea class="form-control item_description" name="item_description" rows="3" placeholder="Enter Service Description..." required></textarea>
              </div>
              <div class="form-group">
                <label>PRICE</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><strong>&#8369;</strong></span>
                    <input type="number" name="price" min="1" class="form-control editPrice" placeholder="Enter Service Price" required />
                </div>
              </div>
              <div class="form-group">
                  <label>STATUS</label>
                  <select class="form-control" name="trash" required>
                      <option value="N" class="active">Active</option>
                      <option value="Y" class="inactive">In-Active</option>
                  </select>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" form="editServicesForm" class="btn btn-success">Update & Save</button>
      </div>
    </div>

  </div>
</div>