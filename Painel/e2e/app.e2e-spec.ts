import { PainelPage } from './app.po';

describe('painel App', () => {
  let page: PainelPage;

  beforeEach(() => {
    page = new PainelPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
