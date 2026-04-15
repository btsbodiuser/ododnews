import { RouterProvider } from 'react-router-dom';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { router } from './router';
import { useThemeStore } from './store';
import { useEffect } from 'react';

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      staleTime: 2 * 60 * 1000,
      retry: 1,
      refetchOnWindowFocus: false,
    },
  },
});

function ThemeInit() {
  const { isDark } = useThemeStore();
  useEffect(() => {
    document.documentElement.classList.toggle('dark', isDark);
  }, [isDark]);
  return null;
}

export default function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <ThemeInit />
      <RouterProvider router={router} />
    </QueryClientProvider>
  );
}
