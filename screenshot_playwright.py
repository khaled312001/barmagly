#!/usr/bin/env python3
"""
Script to take full page screenshot using Playwright (Better for full page screenshots)
Usage: python screenshot_playwright.py
"""

from playwright.sync_api import sync_playwright
import time
import sys

def take_full_page_screenshot(url, output_path="screenshot.png", wait_time=3, email=None, password=None, login_url=None):
    """
    Take a full page screenshot using Playwright
    
    Args:
        url: The URL to screenshot
        output_path: Path to save the screenshot
        wait_time: Time to wait for page to load (in seconds)
        email: Email for login (optional)
        password: Password for login (optional)
        login_url: Login page URL (optional)
    """
    with sync_playwright() as p:
        print("Launching browser...")
        browser = p.chromium.launch(headless=True)
        
        # Create a new page
        page = browser.new_page()
        
        # Set viewport size
        page.set_viewport_size({"width": 1920, "height": 1080})
        
        # Set language to English first via cookie
        base_url = url.split('/admin')[0] if '/admin' in url else url.split('/')[0] + '//' + url.split('/')[2]
        page.goto(base_url, wait_until="networkidle")
        page.context.add_cookies([{
            'name': 'front_lang',
            'value': 'en',
            'domain': '127.0.0.1',
            'path': '/',
        }])
        time.sleep(1)
        
        # Login if credentials provided
        if email and password:
            if not login_url:
                # Try to find login URL from dashboard URL
                if "/admin/dashboard" in url:
                    login_url = url.replace("/admin/dashboard", "/admin/login")
                else:
                    login_url = url.replace(url.split("/")[-1], "login")
            
            print(f"Logging in at: {login_url}")
            page.goto(login_url, wait_until="networkidle")
            time.sleep(2)
            
            # Fill login form
            try:
                # Wait for email input
                page.wait_for_selector('input[name="email"]', timeout=10000)
                page.fill('input[name="email"]', email)
                print("Email filled")
                
                # Wait for password input
                page.wait_for_selector('input[name="password"]', timeout=10000)
                page.fill('input[name="password"]', password)
                print("Password filled")
                
                # Submit form
                page.click('button[type="submit"]')
                print("Login form submitted")
                
                # Wait for redirect to dashboard
                page.wait_for_url("**/admin/dashboard**", timeout=15000)
                print("Successfully logged in!")
                time.sleep(2)
                
                # Change language to English using language switcher route
                try:
                    print("Changing language to English...")
                    # Use the language switcher route - this sets the session
                    base_url = url.split('/admin')[0] if '/admin' in url else url.split('/')[0] + '//' + url.split('/')[2]
                    language_url = f"{base_url}/language-switcher?lang_code=en"
                    
                    # Navigate to language switcher which will set the session
                    response = page.goto(language_url, wait_until="networkidle")
                    time.sleep(3)  # Wait for session to be set
                    
                    # Now navigate to dashboard with English language
                    page.goto(url, wait_until="networkidle")
                    time.sleep(3)  # Wait longer for language to apply
                    print("Language changed to English")
                    
                    # Verify language by checking page content
                    page_content = page.content()
                    if 'Dashboard' in page_content or 'Manage Order' in page_content:
                        print("✓ English language confirmed")
                    else:
                        print("⚠ Warning: Language may not be English")
                        
                except Exception as e:
                    print(f"Language change error: {e}")
                    # Try alternative method - make a POST request to set session
                    try:
                        # Try to set language via fetch request
                        page.evaluate("""
                            async () => {
                                try {
                                    const response = await fetch('/language-switcher?lang_code=en', {
                                        method: 'GET',
                                        credentials: 'include'
                                    });
                                    return response.ok;
                                } catch(e) {
                                    return false;
                                }
                            }
                        """)
                        time.sleep(2)
                        page.reload(wait_until="networkidle")
                        time.sleep(2)
                        print("Language set via fetch request")
                    except:
                        pass
            except Exception as e:
                print(f"Login error: {e}")
                print("Continuing anyway...")
        
        print(f"Loading page: {url}")
        page.goto(url, wait_until="networkidle")
        
        # Wait for page to fully load
        print(f"Waiting {wait_time} seconds for page to load...")
        time.sleep(wait_time)
        
        # Wait for sidebar to be visible
        try:
            page.wait_for_selector(".crancy-smenu", timeout=10000)
            print("Sidebar loaded successfully")
        except:
            print("Warning: Sidebar not found, continuing anyway...")
        
        # Scroll to top
        page.evaluate("window.scrollTo(0, 0);")
        time.sleep(1)
        
        # Get sidebar dimensions to ensure full capture
        sidebar_info = page.evaluate("""
            () => {
                const sidebar = document.querySelector('.crancy-smenu');
                const adminMenu = document.querySelector('.admin-menu');
                if (sidebar && adminMenu) {
                    return {
                        sidebarHeight: sidebar.scrollHeight,
                        sidebarOffsetHeight: sidebar.offsetHeight,
                        adminMenuHeight: adminMenu.scrollHeight,
                        adminMenuOffsetHeight: adminMenu.offsetHeight,
                        sidebarBottom: sidebar.getBoundingClientRect().bottom,
                        lastElement: adminMenu.lastElementChild ? adminMenu.lastElementChild.getBoundingClientRect().bottom : 0
                    };
                }
                return null;
            }
        """)
        
        if sidebar_info:
            print(f"Sidebar scroll height: {sidebar_info['sidebarHeight']}px")
            print(f"Admin menu scroll height: {sidebar_info['adminMenuHeight']}px")
            print(f"Last element bottom: {sidebar_info['lastElement']}px")
        
        # Get page dimensions
        page_height = page.evaluate("document.body.scrollHeight")
        viewport_height = page.viewport_size["height"]
        
        print(f"Page height: {page_height}px")
        print(f"Viewport height: {viewport_height}px")
        
        # Calculate required height to capture full sidebar
        if sidebar_info and sidebar_info['adminMenuHeight'] > viewport_height:
            # Set viewport to accommodate full sidebar
            required_height = max(sidebar_info['adminMenuHeight'] + 200, page_height)
            print(f"Setting viewport height to: {required_height}px to capture full sidebar")
            page.set_viewport_size({"width": 1920, "height": int(required_height)})
            time.sleep(1)
        
        # Scroll sidebar to bottom to ensure all content is rendered
        if sidebar_info:
            page.evaluate("""
                () => {
                    const sidebar = document.querySelector('.crancy-smenu');
                    const adminMenu = document.querySelector('.admin-menu');
                    if (sidebar) {
                        sidebar.scrollTop = sidebar.scrollHeight;
                    }
                    if (adminMenu) {
                        adminMenu.scrollTop = adminMenu.scrollHeight;
                    }
                }
            """)
            time.sleep(0.5)
            
            # Scroll back to top
            page.evaluate("""
                () => {
                    const sidebar = document.querySelector('.crancy-smenu');
                    const adminMenu = document.querySelector('.admin-menu');
                    if (sidebar) {
                        sidebar.scrollTop = 0;
                    }
                    if (adminMenu) {
                        adminMenu.scrollTop = 0;
                    }
                    window.scrollTo(0, 0);
                }
            """)
            time.sleep(1)
        
        # Take full page screenshot
        print("Taking full page screenshot...")
        page.screenshot(path=output_path, full_page=True)
        
        print(f"Screenshot saved to: {output_path}")
        
        browser.close()
        print("Done!")

if __name__ == "__main__":
    # Configuration
    URL = "http://127.0.0.1:8000/admin/dashboard"
    OUTPUT_FILE = "admin_dashboard_screenshot.png"
    WAIT_TIME = 5  # seconds
    EMAIL = "info@Barmagly.net"
    PASSWORD = "Admin#Barmagly123"
    LOGIN_URL = "http://127.0.0.1:8000/admin/login"
    
    # Check if URL is provided as command line argument
    if len(sys.argv) > 1:
        URL = sys.argv[1]
    if len(sys.argv) > 2:
        OUTPUT_FILE = sys.argv[2]
    if len(sys.argv) > 3:
        EMAIL = sys.argv[3]
    if len(sys.argv) > 4:
        PASSWORD = sys.argv[4]
    
    print("=" * 50)
    print("Admin Dashboard Screenshot Tool (Playwright)")
    print("=" * 50)
    print(f"URL: {URL}")
    print(f"Output: {OUTPUT_FILE}")
    print(f"Email: {EMAIL}")
    print("=" * 50)
    
    take_full_page_screenshot(URL, OUTPUT_FILE, WAIT_TIME, EMAIL, PASSWORD, LOGIN_URL)

