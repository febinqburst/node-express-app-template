# ${{ values.app_name | title }} Web Application

A modern, multi-theme Flask web application with variety pages, beautiful image galleries, and responsive design. Built for Backstage software templates with a focus on user experience and visual appeal.

## ✨ Features

### 🎨 **Multiple Themes**
- **Default Theme**: Clean and modern design with purple gradients
- **Dark Mode**: Elegant dark theme with purple accents
- **Nature Theme**: Green and earthy tones inspired by nature
- **Ocean Theme**: Blue and aquatic vibes
- **Sunset Theme**: Warm orange and pink colors
- **Minimal Theme**: Clean and simple monochrome design

### 📱 **Variety Pages**
- **Home**: Hero section with features and statistics
- **Gallery**: Photo gallery with filtering and modal views
- **Portfolio**: Project showcase with skills and technologies
- **About**: Personal information with development timeline
- **Contact**: Contact form with FAQ section

### 🖼️ **Rich Media Support**
- Image galleries with lazy loading
- Modal image viewer with descriptions
- Responsive image optimization
- Portfolio project showcases
- Profile and hero images

### 🎯 **Modern Features**
- Fully responsive design (mobile-first)
- Smooth animations and transitions
- Interactive elements and hover effects
- Progressive loading and optimization
- Accessibility-friendly design

## 🚀 Getting Started

### Prerequisites
- Python 3.8+
- pip package manager

### Installation

1. **Install Dependencies**
   ```bash
   pip install -r requirements.txt
   ```

2. **Set Environment Variables** (optional)
   ```bash
   export USER="YourName"
   export PORT=8082
   ```

3. **Run the Application**
   ```bash
   python app.py
   ```

4. **Access the Application**
   Open your browser and go to `http://localhost:8082`

## 📁 Project Structure

```
python-app/
├── app.py                 # Main Flask application
├── requirements.txt       # Python dependencies
├── Dockerfile            # Docker configuration
├── templates/            # HTML templates
│   ├── base.html         # Base template with navigation
│   ├── home.html         # Home page
│   ├── gallery.html      # Photo gallery
│   ├── portfolio.html    # Portfolio showcase
│   ├── about.html        # About page
│   └── contact.html      # Contact form
├── static/               # Static assets
│   ├── css/
│   │   ├── base.css      # Base styles
│   │   └── themes/       # Theme-specific styles
│   │       ├── default.css
│   │       ├── dark.css
│   │       ├── nature.css
│   │       ├── ocean.css
│   │       ├── sunset.css
│   │       └── minimal.css
│   ├── js/
│   │   └── main.js       # JavaScript functionality
│   └── images/           # Image assets
│       ├── gallery/      # Gallery images
│       ├── portfolio/    # Portfolio images
│       ├── hero-bg.jpg   # Hero background
│       └── profile.jpg   # Profile picture
└── docs/                 # Documentation
```

## 🎨 Theme Customization

### Switching Themes
Users can switch themes by:
1. Clicking the "Themes" dropdown in the navigation
2. Selecting their preferred theme
3. The theme persists across page navigation

### Adding New Themes
1. Create a new CSS file in `static/css/themes/`
2. Add theme definition to the `THEMES` dictionary in `app.py`
3. Follow the existing CSS variable structure

## 🖼️ Image Management

### Adding Images
1. **Gallery Images**: Place in `static/images/gallery/`
2. **Portfolio Images**: Place in `static/images/portfolio/`
3. **Profile Images**: Place in `static/images/`

### Image Guidelines
- **Gallery**: 800x600px (4:3 ratio), <500KB
- **Portfolio**: 600x400px (3:2 ratio), <300KB
- **Profile**: 400x400px (1:1 ratio), <200KB
- **Hero**: 1920x1080px (16:9 ratio), <1MB

## 🌐 API Endpoints

The application maintains backward compatibility with API endpoints:

### Web Routes
- `GET /` - Home page
- `GET /gallery` - Photo gallery
- `GET /portfolio` - Portfolio showcase
- `GET /about` - About page
- `GET /contact` - Contact form
- `GET /themes` - Theme selection

### API Routes (JSON)
- `GET /api/details` - Application details
- `GET /health` - Health check

### Theme Parameter
All web routes accept a `theme` parameter:
```
/?theme=dark
/gallery?theme=nature
/portfolio?theme=ocean
```

## 🐳 Docker Deployment

### Build the Image
```bash
docker build -t ${{ values.app_name }} .
```

### Run the Container
```bash
# Basic run
docker run -p 8082:8082 ${{ values.app_name }}

# With custom user
docker run -p 8082:8082 -e USER="YourName" ${{ values.app_name }}

# With custom port
docker run -p 3000:8082 -e PORT=8082 ${{ values.app_name }}
```

## 🔧 Configuration

### Environment Variables
- `USER`: Display name for greetings (default: "World")
- `PORT`: Application port (default: 8082)

### Customization
- **App Name**: Edit templates to replace `${{ values.app_name }}`
- **Content**: Modify data structures in `app.py`
- **Styling**: Edit CSS files in `static/css/themes/`
- **Images**: Replace placeholder images in `static/images/`

## 📱 Responsive Design

The application is fully responsive with breakpoints:
- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: 320px - 767px

Features:
- Mobile-first CSS approach
- Touch-friendly navigation
- Optimized images for all devices
- Accessible design patterns

## 🎯 Browser Support

- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🔄 CI/CD Pipeline

The application includes a Jenkins pipeline that:
1. **Builds** the Docker image
2. **Pushes** to GitHub Container Registry
3. **Deploys** using Docker containers
4. **Monitors** application health

## 📊 Performance

- **Lighthouse Score**: 90+
- **First Contentful Paint**: <2s
- **Time to Interactive**: <3s
- **Cumulative Layout Shift**: <0.1

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 💡 Tips & Tricks

### Performance Optimization
- Use WebP images when possible
- Enable browser caching
- Minimize CSS and JavaScript
- Use lazy loading for images

### Accessibility
- All images have alt text
- Color contrast meets WCAG standards
- Keyboard navigation support
- Screen reader compatibility

### SEO
- Semantic HTML structure
- Meta tags for social sharing
- Structured data markup
- Fast loading times

---

**Built with ❤️ using Flask, HTML5, CSS3, and JavaScript**

For more information, visit the [documentation](docs/index.md) or check out the [live demo](https://your-demo-url.com). 
