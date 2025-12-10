// Get selected item ID from localStorage
const selectedId = localStorage.getItem('selectedId');
let currentData = null;
let map = null;
let marker = null;

// Find data from both arrays
function findItemById(id) {
    let item = restaurantsData.find(r => r.id === id);
    if (!item) {
        item = travelData.find(t => t.id === id);
    }
    return item;
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // ถ้าไม่มี selectedId ให้ใช้ข้อมูลร้านแรกเป็นตัวอย่าง (สำหรับทดสอบ)
    if (!selectedId) {
        console.log('ไม่มี ID ใน localStorage, ใช้ข้อมูลตัวอย่าง');
        // ใช้ร้านแรกเป็นตัวอย่าง
        currentData = restaurantsData[0];
    } else {
        currentData = findItemById(selectedId);
    }
    
    if (!currentData) {
        alert('ไม่พบข้อมูล');
        window.location.href = 'home.html';
        return;
    }
    
    renderDetailPage();
    initializeMap();
});

// Render all content
function renderDetailPage() {
    // Set title
    document.title = currentData.name;
    
    // Render hero gallery
    renderGallery();
    
    // Render basic info
    document.getElementById('restaurantName').textContent = currentData.name;
    document.getElementById('restaurantType').textContent = currentData.type;
    document.getElementById('restaurantDescription').textContent = currentData.description;
    
    // Render rating
    renderRating();
    
    // Render contact info
    document.getElementById('restaurantAddress').textContent = currentData.address;
    document.getElementById('restaurantPhone').textContent = currentData.phone;
    document.getElementById('restaurantHours').textContent = currentData.hours;
    
    // Website
    if (currentData.website) {
        document.getElementById('websiteItem').style.display = 'flex';
        const websiteLink = document.getElementById('restaurantWebsite');
        websiteLink.textContent = currentData.website;
        websiteLink.href = 'https://' + currentData.website;
    }
    
    // Render menu (if exists)
    if (currentData.menu && currentData.menu.length > 0) {
        renderMenu();
    } else {
        document.getElementById('menuSection').style.display = 'none';
    }
    
    // Render reviews
    renderReviews();
    
    // Render social media
    renderSocialMedia();
    
    // Setup action buttons
    setupActionButtons();
}

// Render gallery
function renderGallery() {
    const mainImage = document.querySelector('.main-image img');
    const thumbnailGrid = document.getElementById('thumbnailGrid');
    
    // Set main image
    mainImage.src = currentData.photos[0];
    mainImage.alt = currentData.name;
    
    // Create thumbnails
    thumbnailGrid.innerHTML = currentData.photos.map((photo, index) => `
        <div class="thumbnail-item ${index === 0 ? 'active' : ''}" onclick="changeMainImage(${index})">
            <img src="${photo}" alt="Photo ${index + 1}">
        </div>
    `).join('');
}

// Change main image
function changeMainImage(index) {
    const mainImage = document.querySelector('.main-image img');
    mainImage.src = currentData.photos[index];
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-item').forEach((thumb, i) => {
        if (i === index) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });
}

// Render rating
function renderRating() {
    const starsContainer = document.getElementById('ratingStars');
    const ratingText = document.getElementById('ratingText');
    
    const fullStars = Math.floor(currentData.rating);
    const hasHalfStar = currentData.rating % 1 >= 0.5;
    
    let starsHTML = '';
    
    // Full stars
    for (let i = 0; i < fullStars; i++) {
        starsHTML += '<span>★</span>';
    }
    
    // Half star
    if (hasHalfStar) {
        starsHTML += '<span>★</span>';
    }
    
    // Empty stars
    const emptyStars = 5 - Math.ceil(currentData.rating);
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += '<span style="color: #ddd;">★</span>';
    }
    
    starsContainer.innerHTML = starsHTML;
    ratingText.textContent = `${currentData.rating} (${currentData.reviewCount.toLocaleString()} รีวิว)`;
}

// Render menu
function renderMenu() {
    const menuGrid = document.getElementById('menuGrid');
    
    menuGrid.innerHTML = currentData.menu.map(item => `
        <div class="menu-item">
            <span class="menu-item-name">${item.name}</span>
            <span class="menu-item-price">${item.price} ฿</span>
        </div>
    `).join('');
}

// Render reviews
function renderReviews() {
    const reviewsContainer = document.getElementById('reviewsContainer');
    
    reviewsContainer.innerHTML = currentData.reviews.map(review => `
        <div class="review-item">
            <div class="review-header">
                <div class="review-avatar">${review.avatar}</div>
                <div class="review-info">
                    <div class="review-author">${review.author}</div>
                    <div class="review-date">${formatDate(review.date)}</div>
                </div>
            </div>
            <div class="review-rating">
                ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
            </div>
            <div class="review-text">${review.text}</div>
        </div>
    `).join('');
}

// Render social media buttons
function renderSocialMedia() {
    const socialButtons = document.getElementById('socialButtons');
    const social = currentData.socialMedia;
    
    let buttonsHTML = '';
    
    if (social.facebook) {
        buttonsHTML += `
            <a href="https://facebook.com/${social.facebook}" target="_blank" class="social-btn facebook">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </a>
        `;
    }
    
    if (social.instagram) {
        buttonsHTML += `
            <a href="https://instagram.com/${social.instagram}" target="_blank" class="social-btn instagram">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                Instagram
            </a>
        `;
    }
    
    if (social.line) {
        buttonsHTML += `
            <a href="https://line.me/R/ti/p/${social.line}" target="_blank" class="social-btn line">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.631 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/>
                </svg>
                Line
            </a>
        `;
    }
    
    if (currentData.website) {
        buttonsHTML += `
            <a href="https://${currentData.website}" target="_blank" class="social-btn website">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                </svg>
                Website
            </a>
        `;
    }
    
    if (buttonsHTML) {
        socialButtons.innerHTML = buttonsHTML;
    } else {
        document.getElementById('socialCard').style.display = 'none';
    }
}

// Setup action buttons
function setupActionButtons() {
    // Direction button
    document.getElementById('directionBtn').addEventListener('click', openDirections);
    document.getElementById('getDirectionBtn').addEventListener('click', openDirections);
    
    // Call button
    document.getElementById('callBtn').addEventListener('click', function() {
        window.location.href = 'tel:' + currentData.phone;
    });
    
    // Share button
    document.getElementById('shareBtn').addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: currentData.name,
                text: currentData.shortDescription,
                url: window.location.href
            });
        } else {
            // Fallback: copy link
            navigator.clipboard.writeText(window.location.href);
            alert('ลิงก์ถูกคัดลอกแล้ว!');
        }
    });
}

// Open Google Maps directions
function openDirections() {
    const url = `https://www.google.com/maps/dir/?api=1&destination=${currentData.lat},${currentData.lng}`;
    window.open(url, '_blank');
}

// Initialize Leaflet Map (ใช้ OpenStreetMap ฟรี ไม่ต้อง API Key!)
function initializeMap() {
    const mapElement = document.getElementById('map');
    
    // Check if Leaflet is loaded
    if (typeof L === 'undefined') {
        mapElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">กำลังโหลดแผนที่...</div>';
        return;
    }
    
    const position = [currentData.lat, currentData.lng];
    
    // สร้างแผนที่
    map = L.map('map').setView(position, 15);
    
    // เพิ่ม OpenStreetMap tiles (ฟรี!)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);
    
    // สร้าง custom icon สีแดง
    const redIcon = L.icon({
        iconUrl: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCAzMiA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cGF0aCBkPSJNMTYgNDhDMTYgNDggMzIgMjguOCAzMiAxNkMzMiA3LjE2MzQ0IDI0LjgzNjYgMCAxNiAwQzcuMTYzNDQgMCAwIDcuMTYzNDQgMCAxNkMwIDI4LjggMTYgNDggMTYgNDhaIiBmaWxsPSIjRUY0NDQ0Ii8+CiAgPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iOCIgZmlsbD0id2hpdGUiLz4KPC9zdmc+',
        iconSize: [32, 48],
        iconAnchor: [16, 48],
        popupAnchor: [0, -48]
    });
    
    // เพิ่ม marker
    marker = L.marker(position, { icon: redIcon }).addTo(map);
    
    // เพิ่ม popup
    marker.bindPopup(`
        <div style="padding: 10px; min-width: 200px;">
            <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 600;">${currentData.name}</h3>
            <p style="margin: 0; font-size: 13px; color: #666; line-height: 1.4;">${currentData.address}</p>
        </div>
    `).openPopup();
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
}