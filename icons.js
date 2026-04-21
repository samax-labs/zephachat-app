// ZephaChat SVG Icon Library — no emojis, all inline SVG
const Icons = {
  logo: `<svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect width="40" height="40" rx="12" fill="url(#logoGrad)"/>
    <defs><linearGradient id="logoGrad" x1="0" y1="0" x2="40" y2="40">
      <stop offset="0%" stop-color="#7c6aff"/><stop offset="100%" stop-color="#ff6a9a"/>
    </linearGradient></defs>
    <path d="M8 12C8 10.343 9.343 9 11 9H29C30.657 9 32 10.343 32 12V22C32 23.657 30.657 25 29 25H22L17 31V25H11C9.343 25 8 23.657 8 22V12Z" fill="white" fill-opacity="0.95"/>
    <circle cx="14" cy="17" r="1.5" fill="#7c6aff"/>
    <circle cx="20" cy="17" r="1.5" fill="#7c6aff"/>
    <circle cx="26" cy="17" r="1.5" fill="#7c6aff"/>
  </svg>`,

  send: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M22 2L11 13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`,

  image: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" stroke-width="1.8"/>
    <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
    <path d="M3 16L8 11L12 15L16 10L21 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`,

  video: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="2" y="6" width="14" height="12" rx="2" stroke="currentColor" stroke-width="1.8"/>
    <path d="M16 10L22 7V17L16 14V10Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
  </svg>`,

  document: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
    <path d="M14 2V8H20" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
    <line x1="8" y1="13" x2="16" y2="13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <line x1="8" y1="17" x2="13" y2="17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  audio: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 1C10.34 1 9 2.34 9 4V12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12V4C15 2.34 13.66 1 12 1Z" stroke="currentColor" stroke-width="1.8"/>
    <path d="M5 10V12C5 15.87 8.13 19 12 19C15.87 19 19 15.87 19 12V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <line x1="12" y1="19" x2="12" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <line x1="8" y1="23" x2="16" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  mic: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 1C10.34 1 9 2.34 9 4V12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12V4C15 2.34 13.66 1 12 1Z" fill="currentColor"/>
    <path d="M5 10V12C5 15.87 8.13 19 12 19C15.87 19 19 15.87 19 12V10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <line x1="12" y1="19" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <line x1="8" y1="23" x2="16" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>`,

  micStop: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="8" y="8" width="8" height="8" rx="1" fill="#ff6a6a"/>
    <circle cx="12" cy="12" r="10" stroke="#ff6a6a" stroke-width="1.8"/>
  </svg>`,

  plus: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8"/>
    <line x1="12" y1="7" x2="12" y2="17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <line x1="7" y1="12" x2="17" y2="12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  profile: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.8"/>
    <path d="M4 20C4 16.686 7.582 14 12 14C16.418 14 20 16.686 20 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  chat: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M21 15C21 16.657 19.657 18 18 18H7L3 22V6C3 4.343 4.343 3 6 3H18C19.657 3 21 4.343 21 6V15Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
  </svg>`,

  back: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M12 5L5 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`,

  logout: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M9 21H5C4.47 21 3.96 20.79 3.59 20.41C3.21 20.04 3 19.53 3 19V5C3 4.47 3.21 3.96 3.59 3.59C3.96 3.21 4.47 3 5 3H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    <line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  edit: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M11 4H4C3.47 4 2.96 4.21 2.59 4.59C2.21 4.96 2 5.47 2 6V20C2 20.53 2.21 21.04 2.59 21.41C2.96 21.79 3.47 22 4 22H18C18.53 22 19.04 21.79 19.41 21.41C19.79 21.04 20 20.53 20 20V13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <path d="M18.5 2.5C18.89 2.11 19.41 1.9 19.95 1.9C20.49 1.9 21.01 2.11 21.4 2.5C21.79 2.89 22 3.41 22 3.95C22 4.49 21.79 5.01 21.4 5.4L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>`,

  search: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
    <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  online: `<svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
    <circle cx="5" cy="5" r="4" fill="#4ade80"/>
  </svg>`,

  offline: `<svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
    <circle cx="5" cy="5" r="4" fill="#6b6b80"/>
  </svg>`,

  close: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>`,

  playAudio: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8"/>
    <path d="M10 8L16 12L10 16V8Z" fill="currentColor"/>
  </svg>`,

  rooms: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M21 15C21 16.657 19.657 18 18 18H7L3 22V6C3 4.343 4.343 3 6 3H18C19.657 3 21 4.343 21 6V15Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
    <line x1="8" y1="10" x2="16" y2="10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
    <line x1="8" y1="14" x2="13" y2="14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
  </svg>`,

  dms: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M8 10C8 8.343 9.343 7 11 7H19C20.657 7 22 8.343 22 10V16C22 17.657 20.657 19 19 19H14L11 22V19C9.343 19 8 17.657 8 16V10Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
    <path d="M6 15H5C3.343 15 2 13.657 2 12V6C2 4.343 3.343 3 5 3H13C14.657 3 16 4.343 16 6V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  people: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="9" cy="7" r="3" stroke="currentColor" stroke-width="1.8"/>
    <circle cx="17" cy="8" r="2.5" stroke="currentColor" stroke-width="1.8"/>
    <path d="M2 20C2 17.239 5.134 15 9 15C12.866 15 16 17.239 16 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <path d="M17 14C19.209 14 21 15.567 21 17.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,

  upload: `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M21 15V19C21 19.53 20.79 20.04 20.41 20.41C20.04 20.79 19.53 21 19 21H5C4.47 21 3.96 20.79 3.59 20.41C3.21 20.04 3 19.53 3 19V15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    <path d="M17 8L12 3L7 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    <line x1="12" y1="3" x2="12" y2="15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
  </svg>`,
};
