

                <div class="basket-container" id="basketContainer">
                    <div class="basket-header">
                        <h3>Your Basket</h3>
                        <button class="close-basket" onclick="closeBasket()">&times;</button>
                    </div>

                    <div class="basket-items" id="basketItems">
                        <div class="empty-basket">
                            <i class="fas fa-shopping-basket"></i>
                            <p>Your basket is empty</p>
                        </div>
                    </div>

                    <div class="basket-summary">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal:</span>
                            <span class="summary-value" id="subtotal">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Shipping:</span>
                            <span class="summary-value">$5.00</span>
                        </div>
                        <div class="summary-row total-row">
                            <span class="summary-label">Total:</span>
                            <span class="summary-value total-value" id="total">$5.00</span>
                        </div>
                    </div>

                    <div class="payment-options">
                        <div class="payment-title">Payment Methods:</div>
                        <div class="bank-cards">
                            <div class="bank-card"><img src="https://britishbody.uk/img/fib.png" alt="FIB Bank"></div>
                            <div class="bank-card"><img src="https://britishbody.uk/img/nbi.png" alt="NBI Bank"></div>
                            <div class="bank-card"><img src="https://britishbody.uk/img/arti.png" alt="Arti Bank"></div>
                        </div>
                    </div>

                    <div class="basket-actions">
                        <button class="basket-btn checkout-btn">Proceed to Payment</button>
                        <button class="basket-btn continue-btn">Buy Without Payment</button>
                        <a href="#" class="view-basket">View and Edit Basket</a>
                    </div>
                </div>
