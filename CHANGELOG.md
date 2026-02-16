# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-02-16

### Added

#### Core Features
- **Card Management System**
  - Create cards with front/back images (JPG, PNG, GIF, WEBP)
  - Support for PDF files (high quality print files)
  - Unique card identification: Player + Year + Version
  - Card details: Title, Description, Code, Event, Series
  - Rarity levels: Common, Rare, Ultra Rare, Legendary
  - Print quantity tracking for limited editions

- **Personal Collections**
  - Add cards to personal collection
  - Track multiple copies of same card
  - Mark cards available for trade
  - View collection statistics
  - Export collection to PDF (9 cards per A4 page)
  - Organize by player, year, series

- **Wantlist Management**
  - Create wishlist of wanted cards
  - 4 priority levels: Urgent, High, Medium, Low
  - Export wantlist to PDF
  - Public visibility for trade proposals
  - Statistics by priority

- **Trading System**
  - Propose trades with other collectors
  - Multi-card trades (offer/request)
  - Trade statuses: Pending, Accepted, Rejected, Completed
  - Trade history
  - Notifications for trade updates

- **Ownership Claiming**
  - Claim ownership of cards created by others
  - Upload proof (photo evidence)
  - Moderator review system
  - Ownership transfer with history tracking
  - User collections remain intact
  - Automatic notifications to all parties

- **Public Widget**
  - Embeddable JavaScript widget for external websites
  - 2 lines of HTML code integration
  - Responsive design (mobile/tablet/desktop)
  - Light and dark themes
  - Configurable display options
  - CORS-enabled JSON API
  - Automatic updates

- **Index Display**
  - Latest cards showcase on forum index
  - Configurable number of cards (default: 6)
  - Statistics display (total cards, collectors)
  - Call-to-action for registration
  - Responsive grid layout
  - Rarity badges with colors

#### Internationalization
- **French** (fr) - Complete translation
- **English** (en) - Complete translation
- Auto-detection based on browser language
- Easy to add new languages

#### User Interface
- Modern responsive design
- Mobile-first approach
- Prosilver theme integration
- Custom CSS for card display
- Image optimization and thumbnails
- Lazy loading for images
- Smooth animations and transitions

#### Administration
- **ACP Modules**
  - Settings configuration
  - Card management
  - User management
  - Trade moderation
  - Ownership claim review
  - Statistics dashboard

- **Permissions System**
  - `u_cards_view` - View cards
  - `u_cards_create` - Create cards
  - `u_cards_edit_own` - Edit own cards
  - `u_cards_manage_collection` - Manage collection
  - `u_cards_trade` - Propose trades
  - `u_cards_claim_ownership` - Claim card ownership
  - `m_cards_edit` - Edit all cards (moderators)
  - `m_cards_delete` - Delete cards (moderators)
  - `m_cards_review_claims` - Review ownership claims
  - `a_cards_manage` - Full administration

#### Database
- 7 tables created:
  - `phpbb_cards` - Card catalog
  - `phpbb_card_collections` - User collections
  - `phpbb_card_wantlists` - User wantlists
  - `phpbb_card_trades` - Trade proposals
  - `phpbb_card_trade_items` - Trade details
  - `phpbb_card_ownership_claims` - Ownership claims
  - `phpbb_card_ownership_history` - Ownership change history

#### Security
- SQL injection protection (PDO prepared statements)
- XSS protection (output escaping)
- CSRF protection (form tokens)
- File upload validation (type, size, MIME)
- Permission checks on all actions
- Secure file storage

#### Performance
- Database indexes on frequently queried columns
- Image optimization (automatic resize)
- Thumbnail generation
- Query result pagination
- HTTP caching for widget
- GZIP compression support

### Configuration Options
- Cards per page (default: 24)
- Enable/disable trades
- Enable/disable PDF export
- Max file upload size (default: 10MB)
- Upload directory path
- Show cards on index (yes/no)
- Number of cards on index (default: 6)
- Enable public widget (yes/no)
- Widget cache time (default: 3600s)
- Require proof for claims (yes/no)
- Auto-approve claims after X days
- Notify creator on ownership change

### Documentation
- Complete installation guide (FR/EN)
- User guide
- Widget integration guide
- Ownership claiming guide
- Moderation guide
- Comparison: Standalone vs phpBB extension
- Troubleshooting guide
- FAQ

### Known Issues
- PDF to image conversion requires Imagick or GhostScript
- Widget may not work with very strict CSP policies

### Requirements
- phpBB 3.3.0 or higher
- PHP 7.1 or higher
- MySQL 5.6+ or MariaDB
- PHP GD or Imagick extension (recommended)

---

## [Unreleased]

### Planned Features
- CSV import/export
- Statistics graphs
- REST API
- Mobile app
- QR code scanning
- Push notifications
- Marketplace integration
- Card rating system
- Price tracking
- AI-powered recommendations

---

## Links
- [Repository](https://github.com/verturin/cardcollection)
- [Issues](https://github.com/verturin/cardcollection/issues)
- [Releases](https://github.com/verturin/cardcollection/releases)
