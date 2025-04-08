// Initialize balance
let balance = 0;

// Get container element
const container = document.querySelector('.container');

// The purchase button
const purchaseBtn = document.createElement('button');
purchaseBtn.textContent = 'Purchase';
container.after(purchaseBtn);

// The balance
const balanceDisplay = document.createElement('div');
container.after(balanceDisplay); 

// Balance updated after click button.
const update = () => {
  balanceDisplay.textContent = `Current Balance: $${balance.toFixed(2)}`;
}

// Add values from services to balance.
document.querySelectorAll('.add-to-cart').forEach(btn => {
  btn.onclick = () => {
    balance += Number(btn.dataset.price);
    update();
  }
});

// Click button to buy services.
purchaseBtn.onclick = () => {
  if (balance <= 0) return alert("Nothing in the cart now");
  alert(`You spent $${balance.toFixed(2)}`);
  balance = 0;
  update();
}

update(); 
