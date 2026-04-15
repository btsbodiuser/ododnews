import { create } from 'zustand';
import type { User } from '@/types';

interface ThemeState {
  isDark: boolean;
  toggle: () => void;
  setDark: (dark: boolean) => void;
}

export const useThemeStore = create<ThemeState>((set) => ({
  isDark: typeof window !== 'undefined'
    ? localStorage.getItem('theme') === 'dark' ||
      (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    : false,
  toggle: () =>
    set((state) => {
      const next = !state.isDark;
      localStorage.setItem('theme', next ? 'dark' : 'light');
      document.documentElement.classList.toggle('dark', next);
      return { isDark: next };
    }),
  setDark: (dark) => {
    localStorage.setItem('theme', dark ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', dark);
    set({ isDark: dark });
  },
}));

interface AuthState {
  user: User | null;
  token: string | null;
  setAuth: (user: User, token: string) => void;
  clearAuth: () => void;
}

export const useAuthStore = create<AuthState>((set) => ({
  user: null,
  token: localStorage.getItem('auth_token'),
  setAuth: (user, token) => {
    localStorage.setItem('auth_token', token);
    set({ user, token });
  },
  clearAuth: () => {
    localStorage.removeItem('auth_token');
    set({ user: null, token: null });
  },
}));

interface MobileMenuState {
  isOpen: boolean;
  toggle: () => void;
  close: () => void;
}

export const useMobileMenuStore = create<MobileMenuState>((set) => ({
  isOpen: false,
  toggle: () => set((s) => ({ isOpen: !s.isOpen })),
  close: () => set({ isOpen: false }),
}));
