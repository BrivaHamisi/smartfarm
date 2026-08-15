export default async function run(page, ui) {
  await page.goto('http://127.0.0.1:8001/login', { waitUntil: 'domcontentloaded' });
  await page.waitForSelector('input[name="email"]', { timeout: 15000 });
  await page.fill('input[name="email"]', 'qatmp@smartfarm.test');
  await page.fill('input[name="password"]', 'password');
  await page.keyboard.press('Enter');
  await page.waitForTimeout(1500);
  await page.goto('http://127.0.0.1:8001/dashboard/admin/console', { waitUntil: 'domcontentloaded' });
  await page.waitForFunction(() => document.querySelectorAll('.console-feed').length === 3, null, { timeout: 45000 });
  await page.waitForTimeout(500);

  const geo = await page.evaluate(() => {
    const mono = 'ui-monospace';
    const out = {};

    out.headings = [...document.querySelectorAll('.admin-console-page .fi-wi-table .fi-section-header-heading')].map((h) => {
      const cs = getComputedStyle(h);
      const before = getComputedStyle(h, '::before');
      return {
        text: h.textContent.trim(),
        fontMono: cs.fontFamily.toLowerCase().includes(mono),
        uppercase: cs.textTransform,
        size: cs.fontSize,
        dotBg: before.backgroundColor,
        dotW: before.width,
      };
    });

    const chartHeading = [...document.querySelectorAll('.fi-section-header-heading')].find((h) => h.textContent.trim().startsWith('Activity per day'));
    if (chartHeading) {
      const cs = getComputedStyle(chartHeading);
      out.chartHeadingUntouched = !cs.fontFamily.toLowerCase().includes(mono) && cs.textTransform === 'none';
    }

    out.feeds = [...document.querySelectorAll('.console-feed')].map((feed) => {
      const entries = [...feed.querySelectorAll('.console-entry')];
      const first = entries[0];
      if (!first) return null;
      const labelXs = new Set(entries.slice(0, 5).map((e) => Math.round(e.querySelector('.console-entry__label').getBoundingClientRect().x)));
      const timeX = entries.slice(0, 5).map((e) => Math.round(e.querySelector('.console-entry__time').getBoundingClientRect().right));
      const entryRects = entries.slice(0, 3).map((e) => {
        const r = e.getBoundingClientRect();
        return { h: Math.round(r.height), w: Math.round(r.width) };
      });
      const sep = [...document.querySelectorAll('.console-entry:not(:first-child)')][0];
      return {
        labelXs: [...labelXs],
        timeRightXs: timeX,
        entryRects,
        borderTop: sep ? getComputedStyle(sep).borderTopWidth : null,
        hasRail: entries.every((e) => e.querySelector('.console-entry__rail')),
      };
    });

    out.strong = (() => {
      const l = document.querySelector('.console-entry--strong .console-entry__label');
      if (!l) return null;
      const cs = getComputedStyle(l);
      return { bg: cs.backgroundColor, radius: cs.borderRadius, color: cs.color };
    })();

    out.toolbars = [...document.querySelectorAll('.admin-console-page .fi-wi-table')].map((w) => ({
      sortSelect: !!w.querySelector('select[x-model="column"], select[wire\\:model="tableSortColumn"]'),
      filterBtn: !!w.querySelector('.fi-ta-filters-trigger'),
      footer: !!w.querySelector('.fi-ta-footer'),
    }));

    const pageBox = document.documentElement;
    out.hScroll = pageBox.scrollWidth > pageBox.clientWidth;

    const mast = document.querySelector('.terminal-masthead');
    out.masthead = mast ? { h: Math.round(mast.getBoundingClientRect().height), live: !!mast.querySelector('.terminal-live') } : null;

    return out;
  });

  const menu = await page.evaluate(() => {
    const direct = document.querySelector('button[aria-label="Enable dark theme"]');
    if (direct) { direct.click(); return true; }
    const m = document.querySelector('.fi-user-menu button');
    if (m) { m.click(); return null; }
    return false;
  });
  await page.waitForTimeout(400);
  if (menu === null) await page.evaluate(() => document.querySelector('button[aria-label="Enable dark theme"]')?.click());
  await page.waitForTimeout(700);

  const darkMeta = await page.evaluate(() => {
    const meta = document.querySelector('.console-entry__meta');
    const main = document.querySelector('.console-entry__main');
    const entry = document.querySelector('.console-entry');
    const bg = entry ? getComputedStyle(entry).backgroundColor : null;
    return {
      metaColor: meta ? getComputedStyle(meta).color : null,
      mainColor: main ? getComputedStyle(main).color : null,
      hoverBg: getComputedStyle(entry, null).backgroundColor,
      entryBg: getComputedStyle(entry).backgroundColor,
      timeColor: document.querySelector('.console-entry__time') ? getComputedStyle(document.querySelector('.console-entry__time')).color : null,
    };
  });

  return { geo, darkMeta };
}
