import { createBrowserRouter } from 'react-router-dom';
import { lazy, Suspense } from 'react';
import Layout from '@/pages/Layout';

const Home = lazy(() => import('@/pages/Home'));
const CategoryPage = lazy(() => import('@/pages/Category'));
const ArticlePage = lazy(() => import('@/pages/Article'));
const SearchPage = lazy(() => import('@/pages/Search'));
const AuthorPage = lazy(() => import('@/pages/Author'));
const LoginPage = lazy(() => import('@/pages/Login'));
const NotFound = lazy(() => import('@/pages/NotFound'));

function Lazy({ children }: { children: React.ReactNode }) {
  return <Suspense fallback={<div className="min-h-screen" />}>{children}</Suspense>;
}

export const router = createBrowserRouter([
  {
    path: '/',
    element: <Layout />,
    children: [
      { index: true, element: <Lazy><Home /></Lazy> },
      { path: 'category/:slug', element: <Lazy><CategoryPage /></Lazy> },
      { path: 'article/:slug', element: <Lazy><ArticlePage /></Lazy> },
      { path: 'search', element: <Lazy><SearchPage /></Lazy> },
      { path: 'author/:slug', element: <Lazy><AuthorPage /></Lazy> },
      { path: 'login', element: <Lazy><LoginPage /></Lazy> },
      { path: '*', element: <Lazy><NotFound /></Lazy> },
    ],
  },
], { basename: '/ododnews' });
