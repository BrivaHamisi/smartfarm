export default async function run(page, ui) {
  const out = { steps: [] };

  const login = async () => {
    await page.goto('http://127.0.0.1:8001/login', { waitUntil: 'domcontentloaded' });
    await page.waitForSelector('input[name="email"]', { timeout: 15000 });
    await page.fill('input[name="email"]', 'qatmp@smartfarm.test');
    await page.fill('input[name="password"]', 'password');
    await page.keyboard.press('Enter');
    await page.waitForURL((url) => !url.pathname.endsWith('/login'), { timeout: 20000 }).catch(() => {});
    await page.waitForTimeout(1200);
    out.steps.push('login: submitted');
  };

  const gotoConsole = async () => {
    await page.goto('http://127.0.0.1:8001/dashboard/admin/console', { waitUntil: 'domcontentloaded' });
    await page.waitForSelector('.console-entry', { timeout: 20000 });
    await page.waitForFunction(() => document.querySelectorAll('.console-feed').length === 3, null, { timeout: 20000 });
    await page.waitForTimeout(600);
  };

  const readFeeds = async () => {
    return page.evaluate(() => {
      const entries = [...document.querySelectorAll('.console-entry')];
      const labels = [...new Set(entries.map((e) => e.querySelector('.console-entry__label')?.textContent.trim()))];
      return {
        entryCount: entries.length,
        labels,
        hasMeta: entries.some((e) => e.querySelector('.console-entry__meta')),
        hasTime: entries.some((e) => e.querySelector('.console-entry__time')?.textContent.trim()),
        hasRailDot: entries.every((e) => e.querySelector('.console-entry__dot')),
        headingTexts: [...new Set([...document.querySelectorAll('.fi-section-header-heading')].map((h) => h.textContent.trim()))],
        sortBar: !!document.querySelector('.fi-ta-content + .fi-ta-footer, select[x-model]'),
        toolbarSelect: !!document.querySelector('select[wire\\:model="tableSortColumn"], select[x-model="column"]'),
        feeds: entries.length ? [...document.querySelectorAll('.console-feed')].map((f) => f.querySelectorAll('.console-entry').length) : [],
      };
    });
  };

  await login();
  await gotoConsole();

  const light = await readFeeds();
  out.light = light;

  const styles = await page.evaluate(() => {
    const t = document.querySelector('.console-entry__time');
    const l = document.querySelector('.console-entry[data-tone="danger"] .console-entry__label');
    const meta = document.querySelector('.console-entry__meta');
    const get = (el, prop) => (el ? getComputedStyle(el)[prop] : null);
    return {
      timeFont: t ? getComputedStyle(t).fontFamily : null,
      timeVariant: t ? getComputedStyle(t).fontVariantNumeric : null,
      dangerColor: l ? getComputedStyle(l).color : null,
      metaColor: meta ? getComputedStyle(meta).color : null,
      bodyBg: getComputedStyle(document.body).backgroundColor,
    };
  });
  out.styles = styles;

  await page.screenshot({ path: 'C:/Users/Hp/AppData/Local/Temp/opencode/console_light.png', fullPage: false });
  out.steps.push('screenshot: light desktop');

  const expand = await page.evaluate(() => {
    const btn = document.querySelector('.console-entry__expand-btn');
    return { present: !!btn, text: btn?.textContent.trim() ?? null };
  });
  out.expand = expand;

  if (expand.present) {
    await page.click('.console-entry__expand-btn');
    await page.waitForTimeout(300);
    out.expand.afterClick = await page.evaluate(() => {
      const btn = document.querySelector('.console-entry__expand-btn');
      const main = btn?.closest('.console-entry')?.querySelector('.console-entry__main');
      return { aria: btn?.getAttribute('aria-expanded'), label: btn?.textContent.trim(), openClass: main?.classList.contains('console-entry__main--open') };
    });
  }

  const darkToggle = await page.evaluate(() => {
    const btn = document.querySelector('button[aria-label="Enable dark theme"]');
    if (btn) return { direct: true };
    const menu = document.querySelector('.fi-user-menu button');
    return { direct: false, hasMenu: !!menu };
  });

  if (!darkToggle.direct && darkToggle.hasMenu) {
    await page.click('.fi-user-menu button');
    await page.waitForTimeout(600);
  }
  const darkBtn = await page.evaluate(() => {
    const btn = document.querySelector('button[aria-label="Enable dark theme"]');
    if (btn) btn.click();
    return !!btn;
  });
  await page.waitForTimeout(900);
  out.darkToggle = { found: darkBtn };
  out.darkActive = await page.evaluate(() => document.documentElement.classList.contains('dark'));

  const dark = await readFeeds();
  out.dark = { entryCount: dark.entryCount, labels: dark.labels };

  const darkStyles = await page.evaluate(() => {
    const t = document.querySelector('.console-entry__time');
    const l = document.querySelector('.console-entry[data-tone="danger"] .console-entry__label');
    const meta = document.querySelector('.console-entry__meta');
    return {
      timeColor: getComputedStyle(t).color,
      dangerColor: getComputedStyle(l).color,
      metaColor: getComputedStyle(meta).color,
      bodyBg: getComputedStyle(document.body).backgroundColor,
    };
  });
  out.darkStyles = darkStyles;

  await page.screenshot({ path: 'C:/Users/Hp/AppData/Local/Temp/opencode/console_dark.png', fullPage: false });
  out.steps.push('screenshot: dark desktop');

  await page.setViewportSize({ width: 390, height: 844 });
  await page.waitForTimeout(600);
  const mobile = await readFeeds();
  out.mobile = { entryCount: mobile.entryCount, labels: mobile.labels, hScroll: await page.evaluate(() => document.documentElement.scrollWidth > document.documentElement.clientWidth) };
  await page.screenshot({ path: 'C:/Users/Hp/AppData/Local/Temp/opencode/console_mobile.png', fullPage: false });
  out.steps.push('screenshot: dark mobile');

  return out;
}
