/**
 * Card Collection Widget
 * Embeddable widget to display latest cards on external websites
 * 
 * Usage: <div id="cards-widget" data-limit="6"></div>
 *        <script src="https://your-forum.com/app.php/cards/widget/script"></script>
 */

(function() {
    'use strict';
    
    const API_URL = '{{API_URL}}';
    const BOARD_URL = '{{BOARD_URL}}';
    
    // Widget configuration
    const config = {
        containerId: 'cards-widget',
        limit: 6,
        theme: 'light', // light or dark
        showTitle: true,
        showStats: true,
        showCTA: true,
        language: 'auto', // auto, fr, en
    };
    
    // Translations
    const i18n = {
        fr: {
            title: 'Dernières cartes ajoutées',
            totalCards: 'carte(s)',
            viewAll: 'Voir toutes les cartes',
            joinNow: 'Rejoindre maintenant',
            noImage: 'Pas d\'image',
            by: 'par',
            common: 'Commune',
            rare: 'Rare',
            ultra_rare: 'Ultra Rare',
            legendary: 'Légendaire',
        },
        en: {
            title: 'Latest Cards Added',
            totalCards: 'card(s)',
            viewAll: 'View All Cards',
            joinNow: 'Join Now',
            noImage: 'No image',
            by: 'by',
            common: 'Common',
            rare: 'Rare',
            ultra_rare: 'Ultra Rare',
            legendary: 'Legendary',
        }
    };
    
    // Detect language
    function detectLanguage() {
        if (config.language !== 'auto') {
            return config.language;
        }
        const lang = (navigator.language || navigator.userLanguage || 'en').substring(0, 2);
        return i18n[lang] ? lang : 'en';
    }
    
    const lang = detectLanguage();
    const t = i18n[lang];
    
    // Initialize widget
    function init() {
        const container = document.getElementById(config.containerId);
        if (!container) {
            console.error('Card widget container not found');
            return;
        }
        
        // Get configuration from data attributes
        config.limit = parseInt(container.dataset.limit) || config.limit;
        config.theme = container.dataset.theme || config.theme;
        config.showTitle = container.dataset.showTitle !== 'false';
        config.showStats = container.dataset.showStats !== 'false';
        config.showCTA = container.dataset.showCta !== 'false';
        
        // Show loading
        container.innerHTML = '<div class="cards-widget-loading">Loading cards...</div>';
        
        // Fetch data
        fetchCards();
    }
    
    // Fetch cards from API
    function fetchCards() {
        const url = API_URL + '?limit=' + config.limit;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderWidget(data);
                } else {
                    showError(data.error || 'Failed to load cards');
                }
            })
            .catch(error => {
                console.error('Widget error:', error);
                showError('Failed to load cards');
            });
    }
    
    // Render the widget
    function renderWidget(data) {
        const container = document.getElementById(config.containerId);
        if (!container) return;
        
        let html = '<div class="cards-widget cards-widget-' + config.theme + '">';
        
        // Title
        if (config.showTitle) {
            html += '<div class="cards-widget-header">';
            html += '<h3 class="cards-widget-title">🎴 ' + t.title + '</h3>';
            if (config.showStats) {
                html += '<p class="cards-widget-stats">' + data.total_cards + ' ' + t.totalCards + '</p>';
            }
            html += '</div>';
        }
        
        // Cards grid
        html += '<div class="cards-widget-grid">';
        
        data.cards.forEach(card => {
            html += renderCard(card);
        });
        
        html += '</div>';
        
        // CTA
        if (config.showCTA) {
            html += '<div class="cards-widget-cta">';
            html += '<a href="' + data.catalog_url + '" class="cards-widget-btn cards-widget-btn-primary" target="_blank">' + t.viewAll + '</a>';
            html += '<a href="' + data.register_url + '" class="cards-widget-btn cards-widget-btn-secondary" target="_blank">' + t.joinNow + '</a>';
            html += '</div>';
        }
        
        html += '</div>';
        
        // Inject CSS
        injectCSS();
        
        container.innerHTML = html;
    }
    
    // Render a single card
    function renderCard(card) {
        let html = '<div class="cards-widget-card">';
        html += '<a href="' + card.url + '" target="_blank" class="cards-widget-card-link">';
        
        // Image
        html += '<div class="cards-widget-card-image">';
        if (card.image) {
            html += '<img src="' + card.image + '" alt="' + escapeHtml(card.title) + '" loading="lazy">';
        } else {
            html += '<div class="cards-widget-card-placeholder">🎴<br><small>' + t.noImage + '</small></div>';
        }
        html += '<span class="cards-widget-card-rarity cards-widget-rarity-' + card.rarity + '">' + t[card.rarity] + '</span>';
        html += '</div>';
        
        // Info
        html += '<div class="cards-widget-card-info">';
        html += '<h4>' + escapeHtml(card.player) + '</h4>';
        html += '<p class="cards-widget-card-year">' + card.year + ' - ' + escapeHtml(card.version) + '</p>';
        html += '<p class="cards-widget-card-title">' + escapeHtml(card.title) + '</p>';
        if (card.series) {
            html += '<p class="cards-widget-card-series">📦 ' + escapeHtml(card.series) + '</p>';
        }
        html += '</div>';
        
        html += '</a>';
        html += '</div>';
        
        return html;
    }
    
    // Inject CSS styles
    function injectCSS() {
        if (document.getElementById('cards-widget-css')) {
            return; // Already injected
        }
        
        const css = `
            .cards-widget {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                box-sizing: border-box;
            }
            
            .cards-widget-light {
                background: #fff;
                color: #333;
            }
            
            .cards-widget-dark {
                background: #1a1a1a;
                color: #fff;
            }
            
            .cards-widget-header {
                text-align: center;
                margin-bottom: 20px;
            }
            
            .cards-widget-title {
                font-size: 1.8rem;
                margin: 0 0 10px 0;
                font-weight: bold;
            }
            
            .cards-widget-stats {
                font-size: 1.1rem;
                color: #666;
                margin: 0;
            }
            
            .cards-widget-dark .cards-widget-stats {
                color: #aaa;
            }
            
            .cards-widget-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }
            
            .cards-widget-card {
                border: 1px solid #e1e1e1;
                border-radius: 8px;
                overflow: hidden;
                transition: transform 0.3s, box-shadow 0.3s;
                background: #fff;
            }
            
            .cards-widget-dark .cards-widget-card {
                border-color: #333;
                background: #2a2a2a;
            }
            
            .cards-widget-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            }
            
            .cards-widget-card-link {
                text-decoration: none;
                color: inherit;
                display: block;
            }
            
            .cards-widget-card-image {
                position: relative;
                width: 100%;
                height: 250px;
                background: #f0f0f0;
                overflow: hidden;
            }
            
            .cards-widget-dark .cards-widget-card-image {
                background: #1a1a1a;
            }
            
            .cards-widget-card-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .cards-widget-card-placeholder {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                font-size: 3rem;
                color: #999;
            }
            
            .cards-widget-card-rarity {
                position: absolute;
                top: 8px;
                right: 8px;
                padding: 4px 10px;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: bold;
                text-transform: uppercase;
                color: white;
            }
            
            .cards-widget-rarity-common { background: #9E9E9E; }
            .cards-widget-rarity-rare { background: #2196F3; }
            .cards-widget-rarity-ultra_rare { background: #9C27B0; }
            .cards-widget-rarity-legendary { background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; }
            
            .cards-widget-card-info {
                padding: 15px;
            }
            
            .cards-widget-card-info h4 {
                margin: 0 0 5px 0;
                font-size: 1.1rem;
            }
            
            .cards-widget-card-year {
                font-size: 0.85rem;
                color: #666;
                margin: 0 0 8px 0;
            }
            
            .cards-widget-dark .cards-widget-card-year {
                color: #aaa;
            }
            
            .cards-widget-card-title {
                font-size: 0.9rem;
                margin: 0 0 5px 0;
                font-weight: 600;
            }
            
            .cards-widget-card-series {
                font-size: 0.8rem;
                color: #777;
                margin: 5px 0 0 0;
            }
            
            .cards-widget-dark .cards-widget-card-series {
                color: #999;
            }
            
            .cards-widget-cta {
                text-align: center;
                display: flex;
                gap: 15px;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .cards-widget-btn {
                display: inline-block;
                padding: 12px 30px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 1rem;
                transition: all 0.3s;
                border: none;
                cursor: pointer;
            }
            
            .cards-widget-btn-primary {
                background: #2D5016;
                color: white;
            }
            
            .cards-widget-btn-primary:hover {
                background: #1a3009;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(45, 80, 22, 0.3);
            }
            
            .cards-widget-btn-secondary {
                background: #FFD700;
                color: #333;
            }
            
            .cards-widget-btn-secondary:hover {
                background: #FFC700;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
            }
            
            .cards-widget-loading {
                text-align: center;
                padding: 40px;
                font-size: 1.2rem;
                color: #666;
            }
            
            @media (max-width: 768px) {
                .cards-widget-grid {
                    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                    gap: 15px;
                }
                
                .cards-widget-card-image {
                    height: 200px;
                }
                
                .cards-widget-cta {
                    flex-direction: column;
                }
                
                .cards-widget-btn {
                    width: 100%;
                }
            }
        `;
        
        const style = document.createElement('style');
        style.id = 'cards-widget-css';
        style.textContent = css;
        document.head.appendChild(style);
    }
    
    // Show error message
    function showError(message) {
        const container = document.getElementById(config.containerId);
        if (!container) return;
        
        container.innerHTML = '<div class="cards-widget-error" style="text-align: center; padding: 40px; color: #f44336;">' +
                             'Error: ' + escapeHtml(message) +
                             '</div>';
    }
    
    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();
