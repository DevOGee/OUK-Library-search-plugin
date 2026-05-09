# Library Search Block for Moodle

A premium, production-ready Moodle dashboard block that integrates your University Library search directly into the LMS.

## 🌟 Features

*   **Integrated Search**: Search books, journals, theses, and library resources from Moodle.
*   **OUK Aesthetics**: Styled with Open University of Kenya brand colors (Teal & Gold).
*   **SSO Ready**: Supports optional HMAC-signed token or Email passthrough for seamless library access.
*   **Configurable**: Admins can customize search URLs, placeholder text, and enable/disable quick links.
*   **Responsive**: Works beautifully on mobile and desktop.
*   **Moodle 4.x Compatible**: Built for Moodle 4.1, 4.3+, and beyond.

## 🚀 Quick Start

1.  **Clone the repository** to your Moodle's `blocks` directory:
    ```bash
    cd /path/to/moodle/blocks
    git clone https://github.com/DevOGee/OUK-Library-search-plugin.git librarysearch
    ```
2.  **Install the plugin**: Log in to Moodle as an administrator and go to **Site administration > Notifications**.
3.  **Configure settings**: Go to **Site administration > Plugins > Blocks > Library Search**.
4.  **Add the block**: Go to your Dashboard, turn "Edit mode" on, and add the "Library Search" block.

## 🔧 SSO Integration

The plugin supports several SSO methods:
*   **None**: Public search results only.
*   **HMAC Token**: Sends a base64 encoded string containing `email|timestamp|hash`. The hash is generated using a shared secret.
*   **Email**: Sends the user's email address (useful for internal/trusted environments).

For custom library systems (like Koha or DSpace), we recommend the **HMAC Token** method.

## 🛠️ Developer Information

*   **Component**: `block_librarysearch`
*   **Framework**: Moodle AMD, Mustache templates, Boost/Bootstrap 4/5.
*   **Styles**: Vanilla CSS with OUK design system.

---

© 2025 Open University of Kenya. Built for excellence.
