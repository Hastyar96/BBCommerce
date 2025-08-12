<!-- Order Product Download App Modal -->
<div class="modal fade" id="downloadAppModal" tabindex="-1" aria-labelledby="downloadAppModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
      <div class="modal-header" style="background-color: #2c3e50; border-bottom: none;">
        <h5 class="modal-title text-white" id="downloadAppModalLabel">{{ __('f.download_app') }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="row g-0">
          <div class="col-md-12 d-flex align-items-center" style="background-color: #f8f9fa;">
            <div class="p-4">
              <h3 class="mb-4" style="color: #2c3e50;">{{ __('f.order_faster_app') }}</h3>
              <p style="color: #7f8c8d;">{{ __('f.app_exclusive_offers') }}</p>

              <div class="d-flex flex-column gap-3 mt-4">
                <a href="#" class="btn btn-dark btn-lg d-flex align-items-center justify-content-center" style="background-color: #2c3e50;">
                  <i class="fab fa-apple me-2 fs-4"></i>
                  <div class="text-start">
                    <small class="d-block">{{ __('f.download_on') }}</small>
                    <strong>{{ __('f.app_store') }}</strong>
                  </div>
                </a>

                <a href="#" class="btn btn-dark btn-lg d-flex align-items-center justify-content-center" style="background-color: #2c3e50;">
                  <i class="fab fa-google-play me-2 fs-4"></i>
                  <div class="text-start">
                    <small class="d-block">{{ __('f.get_it_on') }}</small>
                    <strong>{{ __('f.google_play') }}</strong>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #e74c3c; border-top: none;">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">{{ __('f.maybe_later') }}</button>
      </div>
    </div>
  </div>
</div>
